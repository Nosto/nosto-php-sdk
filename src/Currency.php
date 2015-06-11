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
 * Class representing a currency with all it's formatting details Nosto needs.
 */
class NostoCurrency extends NostoObject implements NostoValidatableInterface
{
    const SYMBOL_POS_LEFT = 'left';
    const SYMBOL_POS_RIGHT = 'right';

    /**
     * @var string the currency ISO 4217 code.
     */
    protected $code;

    /**
     * @var string the currency symbol.
     */
    protected $symbol;

    /**
     * @var string the position of the currency symbol ("left" or "right").
     */
    protected $symbolPosition;

    /**
     * @var string the value grouping symbol.
     */
    protected $groupSymbol;

    /**
     * @var string the value decimal symbol.
     */
    protected $decimalSymbol;

    /**
     * @var int the length of the groups separated by the group symbol.
     */
    protected $groupLength;

    /**
     * @var int the decimal precision.
     */
    protected $precision;

    /**
     * Constructor.
     * Assigns the currency properties.
     *
     * @param string $code the currency ISO 4217 code.
     * @param string $symbol the currency symbol.
     * @param bool   $symbolPosition the position of the currency symbol ("left" or "right").
     * @param string $groupSymbol the value grouping symbol.
     * @param string $decimalSymbol the value decimal symbol.
     * @param int    $groupLength the length of the groups separated by the group symbol.
     * @param int    $precision the decimal precision.
     */
    public function __construct($code, $symbol, $symbolPosition, $groupSymbol, $decimalSymbol, $groupLength, $precision)
    {
        $this->code = $code;
        $this->symbol = $symbol;
        $this->symbolPosition = $symbolPosition;
        $this->groupSymbol = $groupSymbol;
        $this->decimalSymbol = $decimalSymbol;
        $this->groupLength = $groupLength;
        $this->precision = $precision;
        $this->validate();
    }

    /**
     * @inheritdoc
     */
    public function getValidationRules()
    {
        return array(
            array(array('code', 'symbol', 'symbolPosition', 'groupSymbol', 'decimalSymbol', 'groupLength', 'precision'), 'required'),
            array(array('code'), 'currency', 'standard' => 'iso-4217'),
            array(array('symbolPosition'), 'in', 'range' => array(self::SYMBOL_POS_LEFT, self::SYMBOL_POS_RIGHT)),
            array(array('groupLength', 'precision'), 'number', 'integer' => true)
        );
    }

    /**
     * Getter for the currency code.
     *
     * @return string the currency ISO 4217 code.
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Getter for the currency symbol.
     *
     * @return string the currency symbol.
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Getter for the currency symbol position.
     *
     * @return string the position "left" or "right".
     */
    public function getSymbolPosition()
    {
        return $this->symbolPosition;
    }

    /**
     * Getter for the grouping symbol.
     *
     * @return string the value grouping symbol.
     */
    public function getGroupSymbol()
    {
        return $this->groupSymbol;
    }

    /**
     * Getter for the decimal symbol.
     *
     * @return string the value decimal symbol.
     */
    public function getDecimalSymbol()
    {
        return $this->decimalSymbol;
    }

    /**
     * Getter for the length of the groups separated by the group symbol.
     *
     * @return int the group length.
     */
    public function getGroupLength()
    {
        return $this->groupLength;
    }

    /**
     * Getter for the decimal precision.
     *
     * @return int the decimal precision.
     */
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * Validates the currency.
     *
     * @throws NostoException if the currency is invalid.
     */
    protected function validate()
    {
        $validator = new NostoValidator($this);
        if (!$validator->validate()) {
            foreach ($validator->getErrors() as $errors) {
                throw new NostoException(sprintf('Invalid Nosto currency. %s', $errors[0]));
            }
        }
    }
}
