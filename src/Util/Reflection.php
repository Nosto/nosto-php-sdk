<?php
/**
 * Copyright (c) 2020, Nosto Solutions Ltd
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
 * @copyright 2020 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Util;

use Nosto\NostoException;

/**
 * Util class for figuring out reflection and properties
 *
 * @package Nosto\Util
 */
class Reflection
{
    const GETTER_KEY = 'getter';
    const SETTER_KEY = 'setter';

    /**
     * Recursively lists all the properties of the given class by traversing up the class hierarchy
     *
     * @param $obj object the object whose properties to list
     * @return array the array of the keys and properties of the object
     */
    public static function getObjectProperties($obj)
    {
        $properties = [];
        try {
            $rc = new \ReflectionClass($obj);
            do {
                $rp = [];

                // Note that we will not include any properties in traits
                $traits = $rc->getTraits();
                $skipProperties = [];
                if (!empty($traits)) {
                    foreach ($traits as $trait) {
                        foreach ($trait->getProperties() as $traitProperty) {
                            $skipProperties[] = $traitProperty->getName();
                        }
                    }
                }
                /* @var $p \ReflectionProperty */
                foreach ($rc->getProperties() as $p) {
                    if (in_array($p->getName(), $skipProperties, true)) {
                        continue;
                    }
                    $p->setAccessible(true);
                    $rp[$p->getName()] = $p->getValue($obj);
                }
                /** @noinspection SlowArrayOperationsInLoopInspection */
                $properties = array_merge($rp, $properties);
            } while ($rc = $rc->getParentClass());
        } catch (\ReflectionException $e) {
            //
        }
        return $properties;
    }


    /**
     * Returns setters and getters for class variables. Note that this only returns
     * setters and getters for properties where both, setter and getter are defined
     *
     * @param $object
     * @return array Format is ['getter' => 'getMethod', setter' => 'setMethod']
     * @throws NostoException
     * @throws \ReflectionException
     */
    public static function parseGettersAndSetters($object)
    {
        if (!is_object($object)) {
            throw new NostoException('Cannot parse methods for non-object');
        }
        $class = new \ReflectionClass($object);
        $methods = [];
        foreach ($class->getProperties() as $property) {
            $setterName = null;
            $getterName = null;
            $getter = sprintf('get%s', $property->getName());
            if ($class->hasMethod($getter)) {
                $reflectionMethod = new \ReflectionMethod(get_class($object), $getter);
                if ($reflectionMethod->isPublic()) {
                    $getterName = $reflectionMethod->getName();
                }
            }
            $setter = sprintf('set%s', $property->getName());
            if ($class->hasMethod($setter)) {
                $reflectionMethod = new \ReflectionMethod(get_class($object), $setter);
                if ($reflectionMethod->isPublic()) {
                    $setterName = $reflectionMethod->getName();
                }
            }
            if ($setterName && $getterName) {
                $methods[] = [self::GETTER_KEY => $getterName, self::SETTER_KEY => $setterName];
            }
        }
        return $methods;
    }
}
