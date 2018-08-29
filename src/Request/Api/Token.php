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

namespace Nosto\Request\Api;

use Nosto\AbstractObject;
use Nosto\Helper\ValidationHelper;
use Nosto\NostoException;
use Nosto\Types\ValidatableInterface;

/**
 * Class representing an API token for the Nosto API's.
 */
class Token extends AbstractObject implements ValidatableInterface
{
    const API_SSO = 'sso';
    const API_PRODUCTS = 'products';
    const API_EXCHANGE_RATES = 'rates';
    const API_SETTINGS = 'settings';
    const API_EMAIL = 'email';
    const API_CREATE = 'create'; // Special token related to the platform
    const API_GRAPHQL = 'apps'; // Special token related to the platform

    /**
     * @var array list of valid api tokens to request from Nosto.
     */
    public static $tokenNames = array(
        self::API_SSO,
        self::API_PRODUCTS,
        self::API_EXCHANGE_RATES,
        self::API_SETTINGS,
        self::API_EMAIL,
        self::API_GRAPHQL
    );
    /**
     * @var string the token name, must be one of the defined tokens from self::$tokenNames.
     */
    private $name;
    /**
     * @var string the token value, e.g. the actual token string.
     */
    private $value;

    /**
     * Constructor.
     * Create a new token with name and value.
     *
     * @param string $name the token name (must be one of self::$tokenNames).
     * @param string $value the token value string.
     * @throws NostoException
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
        $this->validate();
    }

    /**
     * Validates the token attributes.
     *
     * @throws NostoException if any attribute is invalid.
     */
    protected function validate()
    {
        $validator = new ValidationHelper($this);
        if (!$validator->validate()) {
            foreach ($validator->getErrors() as $errors) {
                throw new NostoException(sprintf('Invalid Nosto API token. %s', $errors[0]));
            }
        }
    }

    /**
     * Parses a list of token name=>value pairs and creates token instances of them.
     *
     * @param array $tokens the list of token name=>value pairs.
     * @param string $prefix optional prefix for the token name in the list.
     * @param string $postfix optional postfix for the token name in the list.
     * @return Token[] a list of token instances.
     */
    public static function parseTokens(array $tokens, $prefix = '', $postfix = '')
    {
        $parsedTokens = array();
        foreach (self::$tokenNames as $name) {
            $key = $prefix . $name . $postfix;
            if (isset($tokens[$key])) {
                $parsedTokens[$name] = new self($name, $tokens[$key]);
            }
        }
        return $parsedTokens;
    }

    /**
     * Returns all available API token names.
     *
     * @return array the token names.
     */
    public static function getApiTokenNames()
    {
        return self::$tokenNames;
    }

    /**
     * Returns mandatory API token names.
     *
     * @return array the token names.
     */
    public static function getMandatoryApiTokenNames()
    {
        return array(
            self::API_SSO,
            self::API_PRODUCTS
        );
    }

    /**
     * @inheritdoc
     */
    public function validationRules()
    {
        return array(
            array(array('name', 'value'), 'required'),
            array(array('name'), 'in', array_merge(self::$tokenNames, array(self::API_CREATE)))
        );
    }

    /**
     * Returns the token name.
     *
     * @return string the token name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the token value.
     *
     * @return string the token value.
     */
    public function getValue()
    {
        return $this->value;
    }
}
