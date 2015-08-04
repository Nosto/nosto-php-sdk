<?php
/**
 * Copyright (c) 2015, Nosto Solutions Ltd
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
 * @copyright 2015 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 */

/**
 * Validator util that is used to validate `validatable` objects.
 */
class NostoValidator
{
    /**
     * @var NostoValidatableInterface the object to validate.
     */
    protected $object;

    /**
     * @var array the property names to validate.
     */
    public $properties = array();

    /**
     * @var array map of validation errors per attribute.
     */
    protected $errors = array();

    /**
     * @var array list of supported validators.
     */
    private static $validators = array(
        'required' => 'NostoValidatorRequired',
        'in' => 'NostoValidatorRange',
        'number' => 'NostoValidatorNumber',
        'currency' => 'NostoValidatorCurrency',
    );

    /**
     * Constructor.
     * Creates a new validator for the object to validate.
     *
     * @param NostoValidatableInterface $object the object to validate.
     */
    public function __construct(NostoValidatableInterface $object)
    {
        $this->object = $object;
    }

    /**
     * Validates the `validatable` object based on it's validation rules.
     *
     * @return bool true if the object is valid, false otherwise.
     * @throws NostoException if the rule validator is not found.
     */
    public function validate()
    {
        foreach ($this->object->getValidationRules() as $rule) {
            if (!isset($rule[0], $rule[1]) || !is_array($rule[0]) || !is_string($rule[1])) {
                throw new NostoException('Validator rule is not properly formatted. Format: array(array("propertyName"), "validatorName", [ "optionalKey" => "optionalValue", ... ] )');
            }
            $validator = self::forgeValidator($rule[1], $this->object, $rule[0], array_slice($rule, 2));
            if (!$validator->validate()) {
                $this->errors = $validator->getErrors();
                return false;
            }
        }
        return true;
    }

    /**
     * Forges a new validator instance.
     *
     * @param string $name the name of the validator (one of the keys in self::$validators).
     * @param NostoValidatableInterface $object the object to validate.
     * @param array $properties the property names to validate.
     * @param array $options additional options to configure the validator with.
     * @return NostoValidator the validator instance.
     * @throws NostoException if the validator cannot be created.
     */
    public static function forgeValidator($name, $object, array $properties, array $options = array())
    {
        if (!isset(self::$validators[$name])) {
            throw new NostoException(sprintf('Nosto validator "%s" does not exist.', $name));
        }
        $className = self::$validators[$name];
        /** @var NostoValidator $instance */
        $instance = new $className($object);
        $instance->setProperties($properties);
        foreach ($options as $name => $value) {
            if (!is_string($name) || !property_exists($instance, $name)) {
                throw new NostoException('Validator rule options must be an associative array with validator property names as keys.');
            }
            $instance->{$name} = $value;
        }
        return $instance;
    }

    /**
     * Setter for the properties to be validated.
     *
     * @param array $properties the property names.
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    /**
     * Returns if the object contains validation errors.
     *
     * @return bool true if contains errors, false otherwise.
     */
    public function hasErrors()
    {
        return (bool)count($this->errors);
    }

    /**
     * Returns the validations errors per attribute.
     *
     * @return array the list of error messages.
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Adds a new validation error message for the attribute.
     *
     * @param string $attribute the attribute name.
     * @param string $message the error message.
     */
    protected function addError($attribute, $message)
    {
        if (!isset($this->errors[$attribute])) {
            $this->errors[$attribute] = array();
        }
        $this->errors[$attribute][] = $message;
    }
}
