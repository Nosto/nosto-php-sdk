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

use Nosto\Types\Markupable;
use Nosto\Types\MarkupableCollection;
use Nosto\Types\Sanitizable;
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
        return self::_objectToMarkup($object, $key, $spaces, $indent, 'displace:none');
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
    private static function _objectToMarkup($object, $key, $spaces = 0, $indent = 2, $style = null)
    {
        if (!$object) {
            return "";
        }

        if ($object instanceof Sanitizable) {
            $object = $object->sanitize();
        }

        $spacesStr = str_repeat(' ', $spaces);

        if ($object instanceof Markupable) {
            $key = $object->getMarkupKey();
        }

        if (is_scalar($object)) {
            $styleStatement = '';
            if ($style) {
                $styleStatement = sprintf(' style="%s"', $style);
            }
            $classStatement = sprintf(' class="%s"', SerializationHelper::toSnakeCase($key));
            $markup = $spacesStr
                . '<span'
                . $classStatement
                . $styleStatement
                . '>'
                . $object
                . self::SPAN_END
                . PHP_EOL;
        } else {
            //begin block
            $markup = $spacesStr . sprintf(self::SPAN_START, SerializationHelper::toSnakeCase($key)) . PHP_EOL;
            $childMarkupKey = null;
            $traversable = null;
            if (is_array($object) || $object instanceof Traversable) {
                $traversable = $object;
            } elseif (is_object($object)) {
                $traversable = SerializationHelper::getProperties($object);
            }

            if (is_array($traversable) && SerializationHelper::isAssoc($traversable)) {
                foreach ($traversable as $index => $childValue) {
                    $childMarkupKey = $index;
                    if ($object instanceof MarkupableCollection) {
                        if ($object->getChildMarkupKey()) {
                            $childMarkupKey = $object->getChildMarkupKey();
                        }
                    }

                    $markup .= self::objectToMarkup($childValue, $childMarkupKey, $spaces + $indent);
                }
            } else {
                foreach ($traversable as $childValue) {
                    $childMarkupKey = $key;
                    if ($object instanceof MarkupableCollection) {
                        if ($object->getChildMarkupKey()) {
                            $childMarkupKey = $object->getChildMarkupKey();
                        }
                    }

                    $markup .= self::objectToMarkup($childValue, $childMarkupKey, $spaces + $indent, $indent);
                }
            }
            //end block
            $markup .= $spacesStr . self::SPAN_END . PHP_EOL;
        }

        return $markup;
    }
}
