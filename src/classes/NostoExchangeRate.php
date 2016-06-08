<?php
/**
 * Copyright (c) 2016, Nosto Solutions Ltd
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
 * @copyright 2016 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

/**
 * Class representing a currency exchange rate.
 */
class NostoExchangeRate implements NostoExchangeRateInterface
{
    /**
     * @var string the name for the exchange rate (can be different than the ISO 4217).
     */
    private $name;

    /**
     * @var string the currencyCode code for the exchange rate (ISO 4217).
     */
    private $currencyCode;

    /**
     * @var string the exchange rate value.
     */
    private $exchangeRate;

    /**
     * Constructor.
     * Assigns exchange rate properties and validates them.
     *
     * @param string $name the name of the exchange rate
     * @param string $currencyCode the currencyCode code for the exchange rate.
     * @param string $exchangeRate the exchange rate value.
     *
     */
    public function __construct($name, $currencyCode, $exchangeRate)
    {
        $this->name = (string)$name;
        $this->currencyCode = $currencyCode;
        $this->exchangeRate = (string)$exchangeRate;
    }

    /**
     * Getter for the exchange rates currencyCode code.
     *
     * @return string the currencyCode code.
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Getter for the exchange rate value.
     *
     * @return string the exchange rate.
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }
}
