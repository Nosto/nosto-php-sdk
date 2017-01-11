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
 * Value Object representing a currency formatting, e.g. "1.234,56".
 */
final class NostoCurrencyFormat
{
    private $currencyBeforeAmount = false;

    /**
     * @var string the grouping symbol/char.
     */
    private $groupingSeparator;

    /**
     * @var string the decimal symbol/char.
     */
    private $decimalCharacter;

    /**
     * @var int the value precision.
     */
    private $decimalPlaces;

    /**
     * @var string the currency symbol, e.g. "$".
     */
    private $currencyToken;

    /**
     * Constructor.
     * Sets up this Value Object with given data.
     *
     * @param $currencyBeforeAmount
     * @param $currencyToken
     * @param $decimalCharacter
     * @param string $groupingSeparator the decimal symbol/char.
     * @param int $decimalPlaces the value precision.
     */
    public function __construct(
        $currencyBeforeAmount,
        $currencyToken,
        $decimalCharacter,
        $groupingSeparator,
        $decimalPlaces
    ) {
        $this->currencyBeforeAmount = $currencyBeforeAmount;
        $this->currencyToken = $currencyToken;
        $this->decimalCharacter = $decimalCharacter;
        $this->groupingSeparator = $groupingSeparator;
        $this->decimalPlaces = (int)$decimalPlaces;
    }

    /**
     * Returns the currency symbol position
     *
     * @return bool the currency symbol position
     */
    public function getCurrencyBeforeAmount()
    {
        return $this->currencyBeforeAmount;
    }

    /**
     * Returns the decimal symbol/char.
     *
     * @return string the decimal symbol/char.
     */
    public function getDecimalCharacter()
    {
        return $this->decimalCharacter;
    }

    /**
     * Returns the grouping separator
     *
     * @return string the grouping separator
     */
    public function getGroupingSeparator()
    {
        return $this->groupingSeparator;
    }

    /**
     * Returns the currency token
     *
     * @return string the currency token
     */
    public function getCurrencyToken()
    {
        return $this->currencyToken;
    }

    /**
     * Returns the decimal places
     *
     * @return int the decimal places
     */
    public function getDecimalPlaces()
    {
        return $this->decimalPlaces;
    }
}
