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
use Nosto\Helper\SerializationHelper;
use ReflectionClass;
use ReflectionException;
use Traversable;

/**
 * Helper class for serialize objects to JSON using a snake-case naming convention.
 * It is not necessary to use this class directly, as all operation classes
 * automatically use this helper to serialize objects to JSON
 */
class HtmlMarkupSerializationHelper extends AbstractHelper
{
    public static function objectToMarkup($object, $key, $keyForArrayItem, $spaces = 0, $indent = 2)
    {
        if (!$object) {
            return "";
        }

        $markup = '';
        $spacesStr = str_repeat(' ', $spaces);
        if (is_array($object) ||  $object instanceof Traversable) {
            $markup .= $spacesStr . sprintf("<span class=\"%s\">", SerializationHelper::toSnakeCase($key)) . PHP_EOL;
            if(is_array($object) && SerializationHelper::isAssoc($object)) {
                foreach ($object as $arrayKey => $arrayValue) {
                    $markup .= self::objectToMarkup($arrayValue, $arrayKey, $arrayKey, $spaces + $indent, $indent);
                }
            } else {
                foreach ($object as $arrayValue) {
                    $markup .= self::objectToMarkup($arrayValue, $keyForArrayItem, $keyForArrayItem,$spaces + $indent, $indent);
                }
            }
            $markup .= $spacesStr . "</span>" . PHP_EOL;
        } elseif (is_object($object)) {
            $cssClass = $key;
            if ($object instanceof Markupable && $object->getMarkupKey()) {
                $cssClass = $object->getMarkupKey();
            }

            $markup .= $spacesStr . sprintf("<span class=\"%s\">", SerializationHelper::toSnakeCase($cssClass)) . PHP_EOL;

            $properties = SerializationHelper::getProperties($object);

            foreach ($properties as $propertyKey => $propertyValue) {
                $propertyKeyForArrayItem = $propertyKey;
                if ($object instanceof Markupable) {
                    if ($object->getMarkupKeyForArrayPropertyItem($propertyKey)) {
                        $propertyKeyForArrayItem = $object->getMarkupKeyForArrayPropertyItem($propertyKey);
                    }
                }

                $markup .= self::objectToMarkup($propertyValue, $propertyKey, $propertyKeyForArrayItem, $spaces + $indent, $indent);
            }

            $markup .= $spacesStr . "</span>" . PHP_EOL;
        } else {
            $span = sprintf("<span class=\"%s\">", SerializationHelper::toSnakeCase($key));
            $endx = "</span>";
            $markup = $markup . $spacesStr . $span . $object . $endx . PHP_EOL;
        }

        return $markup;
    }
}
