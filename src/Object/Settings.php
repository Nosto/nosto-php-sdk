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

namespace Nosto\Object;

use Nosto\AbstractObject;
use Nosto\Types\SettingsInterface;

/**
 * Model class for containing basic account account related information used when
 * creating new accounts or updating the settings. This is a subset of the information
 * used when creating an account as information contained in this model is considered to
 * be settings that may change over time.
 */
class Settings extends AbstractObject implements SettingsInterface
{
    /**
     * @var string the name of the store to be used for identifying accounts
     */
    private $title;

    /**
     * @var string the language ISO (ISO 639-1) code of the admin interface
     */
    private $languageCode;

    /**
     * @var string the store front end URL.
     */
    private $frontPageUrl;

    /**
     * @var string the store currency ISO (ISO 4217) code.
     */
    private $currencyCode;

    /**
     * @var array list of currency codes and the currency formats objects supported by the store .
     */
    private $currencies = array();

    /**
     * @var string default variation id
     */
    private $defaultVariantId = null;

    /**
     * @var bool if the store uses exchange rates to manage multiple currencies.
     */
    private $useExchangeRates = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Dummy
    }

    /**
     * The 2-letter ISO code (ISO 639-1) for the language used by the shop for
     * which the account is created for.
     *
     * @return string the language ISO code.
     */
    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    /**
     * Sets the store language ISO (ISO 639-1) code.
     *
     * @param string $languageCode the language ISO code.
     */
    public function setLanguageCode($languageCode)
    {
        $this->languageCode = $languageCode;
    }

    /**
     * Returns an array of currencies used for this account
     *
     * @return array
     */
    public function getCurrencies()
    {
        return empty($this->currencies) ? null : $this->currencies;
    }

    /**
     * Sets the currencies
     *
     * @param $currencyCode
     * @param $currencyFormat
     */
    public function addCurrency($currencyCode, $currencyFormat)
    {
        $this->currencies[$currencyCode] = $currencyFormat;
    }

    /**
     * Sets the currencies
     *
     * @param $currencies
     */
    public function setCurrencies(array $currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * The shops name for which the account is to be created for.
     *
     * @return string the name.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the store title.
     *
     * @param string $title the store title.
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Absolute url to the front page of the shop for which the account is
     * created for.
     *
     * @return string the url.
     */
    public function getFrontPageUrl()
    {
        return $this->frontPageUrl;
    }

    /**
     * Sets the store front page url.
     *
     * @param string $url the front page url.
     */
    public function setFrontPageUrl($url)
    {
        $this->frontPageUrl = $url;
    }

    /**
     * The 3-letter ISO code (ISO 4217) for the currency used by the shop for
     * which the account is created for.
     *
     * @return string the currency ISO code.
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Sets the store currency ISO (ISO 4217) code.
     *
     * @param string $code the currency ISO code.
     */
    public function setCurrencyCode($code)
    {
        $this->currencyCode = $code;
    }

    /**
     * Returns if the exchange rates are used
     *
     * @return boolean
     */
    public function getUseExchangeRates()
    {
        return $this->useExchangeRates;
    }

    /**
     * Setter for useCurrencyExchangeRates
     *
     * @param boolean $useExchangeRates
     */
    public function setUseCurrencyExchangeRates($useExchangeRates)
    {
        $this->useExchangeRates = $useExchangeRates;
    }

    /**
     * Return the default variation id
     *
     * @return string
     */
    public function getDefaultVariantId()
    {
        return $this->defaultVariantId;
    }

    /**
     * Sets the default variation id
     *
     * @param string $defaultVariantId
     */
    public function setDefaultVariantId($defaultVariantId)
    {
        $this->defaultVariantId = $defaultVariantId;
    }
}
