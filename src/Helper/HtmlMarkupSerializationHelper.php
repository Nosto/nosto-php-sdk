<?php
/**
 * Copyright (c) 2017, Nosto Solutions Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its contributors
 * may be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Nosto Solutions Ltd <contact@nosto.com>
 * @copyright 2017 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Helper;

use Nosto\Object\MarkupableString;
use Nosto\Types\MarkupableInterface;
use Nosto\Types\MarkupableCollectionInterface;
use Nosto\Types\SanitizableInterface;
use Traversable;

/**
 * Helper class for serialize objects to JSON using a snake-case naming convention.
 * It is not necessary to use this class directly, as all operation classes
 * automatically use this helper to serialize objects to JSON
 */
class HtmlMarkupSerializationHelper extends AbstractHelper
{
    const SPAN_START = '<span class="%s">';
    const SPAN_END = '</span>';
    const DIV_START_NOTRANSLATE = '<div class="notranslate" style="display:none">';
    const DIV_END = '</div>';
    const STYLE_DISPLAY_NONE = 'display:none';

    /**
     * Serialize the object to html
     *
     * @param mixed $object to be serialized
     * @param string $key the html element class
     * @param int $spaces
     * @param int $indent
     * @return string html
     */
    public static function objectToMarkup($object, $key, $spaces = 0, $indent = 2)
    {
        $spacesStr = str_repeat(' ', $spaces);
        $markup = $spacesStr . self::DIV_START_NOTRANSLATE;
        $markup .= self::toHtml($object, $key, $spaces + $indent, $indent, self::STYLE_DISPLAY_NONE);
        $markup .= $spacesStr . self::DIV_END;
        return $markup;
    }

    /**
     * Servialize the object to html
     *
     * @param mixed $object to be serialized
     * @param string $key $key the html element class
     * @param int $spaces
     * @param int $indent
     * @param string|null $style for the root element, it should be something like 'display:none'
     * @return string html
     */
    private static function toHtml($object, $key, $spaces = 0, $indent = 2, $style = null)
    {
        if (!$object) {
            return "";
        }

        if ($object instanceof SanitizableInterface) {
            $object = $object->sanitize();
        }

        $spacesStr = str_repeat(' ', $spaces);

        if ($object instanceof MarkupableInterface) {
            $key = $object->getMarkupKey();
        }

        //begin block
        $styleStatement = '';
        if ($style) {
            $styleStatement = sprintf(' style="%s"', $style);
        }
        $classStatement = sprintf(' class="%s"', SerializationHelper::toSnakeCase($key));
        $markup = $spacesStr
            . '<span'
            . $classStatement
            . $styleStatement
            . '>';
        if (is_scalar($object) || $object instanceof MarkupableString) {
            $markup .= $object
                . self::SPAN_END
                . PHP_EOL;
        } else {
            $markup .= PHP_EOL;
            $childMarkupKey = null;
            $traversable = null;
            if (is_array($object) || $object instanceof Traversable) {
                $traversable = $object;
            } elseif (is_object($object)) {
                $traversable = SerializationHelper::getProperties($object);
            }
            $markup .= self::arrayToHtml($object, $key, $spaces, $indent, $traversable);
            //end block
            $markup .= $spacesStr . self::SPAN_END . PHP_EOL;
        }

        return $markup;
    }

    /**
     * @param mixed $object the object
     * @param string $key the html element class
     * @param int $spaces
     * @param int $indent
     * @param array|Traversable $traversable the array
     * @return string
     */
    private static function arrayToHtml($object, $key, $spaces, $indent, $traversable)
    {
        $markup = '';

        $isAssociative = is_array($traversable) && SerializationHelper::isAssoc($traversable);
        foreach ($traversable as $index => $childValue) {
            if ($object instanceof MarkupableCollectionInterface && $object->getChildMarkupKey()) {
                $childMarkupKey = $object->getChildMarkupKey();
            } else {
                if ($isAssociative) {
                    $childMarkupKey = $index;
                } else {
                    $childMarkupKey = $key;
                }
            }

            if ($childValue !== null) {
                $markup .= self::toHtml($childValue, $childMarkupKey, $spaces + $indent);
            }
        }
        return $markup;
    }
}
