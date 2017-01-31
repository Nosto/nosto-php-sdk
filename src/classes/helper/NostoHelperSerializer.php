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

/**
 * Helper class for serialize objects to JSON using a snake-case naming convention.
 * It is not necessary to use this class directly, as all operation classes
 * automatically use this helper to serialize objects to JSON
 */
class NostoHelperSerializer extends NostoHelper
{
    // @codeCoverageIgnoreStart
    /** @noinspection PhpUndefinedClassInspection */
    /**
     * Serializes the given object to JSON using a snake-case naming convention.
     * Arrays and objects can both be passed normally.
     *
     * @param $object
     * @return string|scalar
     */
    public static function serialize($object)
    {
        $json = array();
        $props = self::getProperties($object);
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

            $key = self::toSnakeCase($key);
            if (is_object($object->$getter())) {
                $json[$key] = self::serialize($object->$getter());
            } else {
                if (is_array($object->$getter())) {
                    $json[$key] = array();
                    foreach ($object->$getter() as $anObject) {
                        if (is_object($anObject)) {
                            $json[$key][] = self::serialize($anObject);
                        } else {
                            $json[$key][] = $anObject;
                        }
                    }
                } else {
                    $json[$key] = $object->$getter();
                }
            }
        }
        return json_encode($json);
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
     * Recursively lists all the properties of the given class by traversing up the class hierarchy
     *
     * @param $obj object the object whose properties to list
     * @return array the array of the keys and properties of the object
     */
    public static function getProperties($obj)
    {
        $properties = array();
        try {
            $rc = new ReflectionClass($obj);
            do {
                $rp = array();
                /* @var $p \ReflectionProperty */
                foreach ($rc->getProperties() as $p) {
                    $p->setAccessible(true);
                    $rp[$p->getName()] = $p->getValue($obj);
                }
                $properties = array_merge($rp, $properties);
            } while ($rc = $rc->getParentClass());
        } catch (ReflectionException $e) {
            //
        }
        return $properties;
    }
}
