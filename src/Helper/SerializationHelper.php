<?php
/**
 * Copyright (c) 2019, Nosto Solutions Ltd
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
 * @copyright 2019 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Helper;

use Nosto\Util\Reflection;
use \Traversable;

/**
 * Helper class for serialize objects to JSON using a snake-case naming convention.
 * It is not necessary to use this class directly, as all operation classes
 * automatically use this helper to serialize objects to JSON
 */
class SerializationHelper extends AbstractHelper
{

    const SNAKE_CASE = 'snake_case';
    const CAMEL_CASE = 'camel_case';

    public static function serialize($object)
    {
        $items = array();
        if ($object instanceof Traversable || is_array($object)) {
            foreach ($object as $item) {
                if (is_object($item)) {
                    $items[] = self::toArray($item);
                } else {
                    $items[] = $item;
                }
            }
            return json_encode($items);
        } else {
            return json_encode(self::toArray($object));
        }
    }

    // @codeCoverageIgnoreStart
    /** @noinspection PhpUndefinedClassInspection */
    /**
     * Serializes the given object to JSON using a snake-case naming convention.
     * Arrays and objects can both be passed normally.
     * @param $object
     * @param string $keyCaseType
     * @return array
     */
    private static function toArray($object, $keyCaseType = self::SNAKE_CASE)
    {
        $json = array();
        $props = Reflection::getObjectProperties($object);
        foreach ($props as $key => $value) {
            $check_references = explode("_", $key);
            $getter = "";
            if (count($check_references) > 0) {
                foreach ($check_references as $reference) {
                    $getter .= ucfirst($reference);
                }
            } else {
                $getter = ucfirst($key);
            }
            $getter = "get" . $getter;

            if (!method_exists($object, $getter)) {
                continue;
            }
            if ($keyCaseType === self::SNAKE_CASE) {
                $key = self::toSnakeCase($key);
            }
            $value = $object->$getter();
            if (self::isNull($value)) {
                continue;
            }
            if ($value instanceof \Iterator) {
                $value = iterator_to_array($value);
            }
            if (is_object($value)) {
                $json[$key] = self::toArray($value);
            } else {
                if (is_array($value)) {
                    $json[$key] = array();
                    if (ArrayHelper::isAssoc($value)) {
                        foreach ($value as $k => $anObject) {
                            if (is_object($anObject)) {
                                $json[$key][$k] = self::toArray($anObject);
                            } else {
                                $json[$key][$k] = $anObject;
                            }
                        }
                    } else {
                        foreach ($value as $anObject) {
                            if (is_object($anObject)) {
                                $json[$key][] = self::toArray($anObject);
                            } else {
                                $json[$key][] = $anObject;
                            }
                        }
                    }
                } else {
                    $json[$key] = $value;
                }
            }
        }

        return $json;
    }

    /**
     * @param $object
     * @return array
     */
    public static function toAssocArray($object)
    {
        return self::toArray($object, self::CAMEL_CASE);
    }

    /**
     * Converts a camel-cased string to a snake-cased string to comply with the JSON serialization
     * strategy
     *
     * @param $input string the input camel-cased string
     * @return string the converted snake-cased string
     */
    public static function toSnakeCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    /**
     * Check for multiple types of invalid values in a variable and returns.
     *
     * @param $var
     * @return bool
     */
    public static function isNull($var)
    {
        return (!$var && $var !== 0 && $var !== '0' && $var !== false && $var !== 0.00);
    }
}
