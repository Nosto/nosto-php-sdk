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

namespace Nosto\Util\Serializer;

use Nosto\NostoException;
use Nosto\Types\JsonDenormalizableInterface;
use Nosto\Util\Reflection;

class Json
{
    /**
     * @param \JsonSerializable $serializable
     * @return false|string
     */
    public static function serialize(\JsonSerializable $serializable)
    {
        $normalized = $serializable->jsonSerialize();
        return json_encode($normalized);
    }

    /**
     * @param $data
     * @param $class
     * @return \jsonSerializable
     * @throws NostoException
     * @throws \ReflectionException
     */
    public static function deserialize($data, $class)
    {
        $data = self::decode($data);
        return self::denormalize($data, $class);
    }

    /**
     * @param array $data
     * @param $class
     * @return \jsonSerializable
     * @throws NostoException
     * @throws \ReflectionException
     */
    public static function denormalize(array $data, $class)
    {
        $reflectionClass = new \ReflectionClass($class);
        if ($reflectionClass->implementsInterface('Nosto\Types\JsonDenormalizableInterface') === false) {
            throw new NostoException(
                sprintf(
                    'Class %s is not deserializable (does not implement JsonDenormalizableInterface interface)',
                    $reflectionClass
                )
            );
        }
        /** @var \jsonSerializable $object */
        $object = $reflectionClass->newInstance();
        $keys = $object->jsonSerialize();
        $difference = array_diff_key($data, $keys);
        if (!empty($difference)) {
            throw new NostoException(
                sprintf(
                    'Cannot denormalize data to %s - invalid array keys (%s) in data',
                    $reflectionClass,
                    implode($difference)
                )
            );
        }
        $properties = Reflection::getObjectProperties($object);
        $serializableFields = array_keys($keys);
        foreach ($serializableFields as $attribute) {
            // We only handle the ones that can be serialized
            if (array_key_exists($attribute, $properties)) {
                self::setObjectProperty($reflectionClass, $object, $attribute, $data[$attribute]);
            }
        }

        return $object;
    }

    /**
     * Sets an property for an object based on reflection class
     *
     * @param \ReflectionClass $reflectionClass
     * @param $object
     * @param $property
     * @param $value
     * @throws NostoException
     * @throws \ReflectionException
     */
    private static function setObjectProperty(\ReflectionClass $reflectionClass, $object, $property, $value)
    {
        $setter = sprintf('set%s', $property);
        if ($reflectionClass->hasMethod($setter)) {
            $reflectionMethod = $reflectionClass->getMethod($setter);
            if ($reflectionMethod->isPublic()) {
                $parameters = $reflectionMethod->getParameters();
                if (!isset($parameters[0])) {
                    throw new NostoException(
                        sprintf(
                            'Not a valid setter %s in %s',
                            $setter,
                            $reflectionClass->getName()
                        )
                    );
                }
                /* @var \ReflectionParameter $param */
                $param = $parameters[0];
                if (Reflection::isScalarParameter($param)) {
                    $object->$setter($value);
                } elseif($param->getClass() instanceof \ReflectionClass) {
                    $parameterReflectionClass = new \ReflectionClass($param->getClass()->getName());
                    $parameterObject = $parameterReflectionClass->newInstance();
                    if ($parameterObject instanceof JsonDenormalizableInterface) {
                        $object->$setter($parameterObject->jsonDenormalize($value));
                    }
                }
            }
        }
    }

    /**
     * @param string $json
     * @return mixed
     * @throws NostoException
     */
    public static function decode($json)
    {
        $data = json_decode($json, true);
        if ($data === null) {
            throw new NostoException('Could not serialize json. Error was ' . json_last_error_msg());
        }

        return $data;
    }
}