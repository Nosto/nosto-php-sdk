<?php
/**
 * 2013-2016 Nosto Solutions Ltd
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@nosto.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    Nosto Solutions Ltd <contact@nosto.com>
 * @copyright 2013-2016 Nosto Solutions Ltd
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

/**
 * Class representing a currency with all it's formatting details Nosto needs.
 */
final class NostoCurrency
{
    /**
     * @var string the currency ISO 4217 code.
     */
    private $code;

    /**
     * @var NostoCurrencySymbol the currency symbol.
     */
    private $symbol;

    /**
     * @var NostoCurrencyFormat the currency format.
     */
    private $format;

    /**
     * Constructor.
     * Assigns the currency properties.
     *
     * @param NostoCurrencyCode $code the currency ISO 4217 code.
     * @param NostoCurrencySymbol $symbol the currency symbol.
     * @param NostoCurrencyFormat $format the currency formatting.
     */
    public function __construct(NostoCurrencyCode $code, NostoCurrencySymbol $symbol, NostoCurrencyFormat $format)
    {
        $this->code = $code;
        $this->symbol = $symbol;
        $this->format = $format;
    }

    /**
     * Getter for the currency code.
     *
     * @return NostoCurrencyCode the currency ISO 4217 code.
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Getter for the currency symbol.
     *
     * @return NostoCurrencySymbol the currency symbol.
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Getter for the currency format.
     *
     * @return NostoCurrencyFormat the format.
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Returns the currency sub-unit.
     *
     * @return int the sub-unit.
     */
    public function getFractionUnit()
    {
        return NostoCurrencyInfo::getFractionUnit($this->code);
    }

    /**
     * Returns the currency default fraction decimals.
     *
     * @return int the fraction digits.
     */
    public function getDefaultFractionDecimals()
    {
        return NostoCurrencyInfo::getFractionDecimals($this->code);
    }
}
