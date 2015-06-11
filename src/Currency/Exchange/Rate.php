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
 * Class representing a currency exchange rate.
 */
class NostoCurrencyExchangeRate extends NostoObject implements NostoValidatableInterface
{
    /**
     * @var string the currency code for the exchange rate.
     */
    protected $currencyCode;

    /**
     * @var float|string the exchange rate value.
     */
    protected $exchangeRate;

    /**
     * Constructor.
     * Assigns exchange rate properties and validates them.
     *
     * @param string $currencyCode the currency code for the exchange rate.
     * @param float|string $exchangeRate the exchange rate value.
     */
    public function __construct($currencyCode, $exchangeRate)
    {
        $this->currencyCode = $currencyCode;
        $this->exchangeRate = $exchangeRate;
        $this->validate();
    }

    /**
     * @inheritdoc
     */
    public function getValidationRules()
    {
        return array(
            array(array('currencyCode', 'exchangeRate'), 'required'),
            array(array('currencyCode'), 'currency', 'standard' => 'iso-4217'),
            array(array('exchangeRate'), 'number')
        );
    }

    /**
     * Getter for the exchange rates currency code.
     *
     * @return string the currency code.
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Getter for the exchange rate value.
     *
     * @return float|string the exchange rate.
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * Validates the exchange rate.
     *
     * @throws NostoException if the exchange rate is invalid.
     */
    protected function validate()
    {
        $validator = new NostoValidator($this);
        if (!$validator->validate()) {
            foreach ($validator->getErrors() as $errors) {
                throw new NostoException(sprintf('Invalid Nosto currency exchange rate. %s', $errors[0]));
            }
        }
    }
}
