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
 * Meta data class for account related information needed when creating new accounts.
 */
abstract class NostoAccountMeta implements NostoAccountMetaDataInterface
{
    /**
     * @var string the store name.
     */
    protected $title;

    /**
     * @var string the account name.
     */
    protected $name;

    /**
     * @var string the store front end url.
     */
    protected $frontPageUrl;

    /**
     * @var string the store currency ISO (ISO 4217) code.
     */
    protected $currencyCode;

    /**
     * @var string the store language ISO (ISO 639-1) code.
     */
    protected $languageCode;

    /**
     * @var string the owner language ISO (ISO 639-1) code.
     */
    protected $ownerLanguageCode;

    /**
     * @var NostoTaggingMetaAccountOwner the account owner meta model.
     */
    protected $owner;

    /**
     * @var NostoTaggingMetaAccountBilling the billing meta model.
     */
    protected $billing;

    /**
     * @var array list of NostoCurrency objects supported by the store .
     */
    protected $currencies = array();

    /**
     * @var bool if the store uses exchange rates to manage multiple currencies.
     */
    protected $useCurrencyExchangeRates = false;

    /**
     * @var string default variation id
     */
    protected $defaultVariationId = false;

    /**
     * @var string details
     */
    protected $details = false;

    /**
     * @var string sign up api token
     */
    protected $signupApiToken;

    /**
     * @var string platform name
     */
    protected $platform;

    /**
     * @var string partner code
     */
    protected $partnerCode;

    /**
     * Constructor
     *
     * @param string $platform
     * @param string $signupApiToken
     * @param string $partnerCode
     */
    public function __construct($platform, $signupApiToken, $partnerCode)
    {
        $this->platform = $platform;
        $this->signupApiToken = $signupApiToken;
        $this->partnerCode = $partnerCode;
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
     * The shops name for which the account is to be created for.
     *
     * @return string the name.
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the account name.
     *
     * @param string $name the account name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * The name of the account to create.
     * This has to follow the pattern of
     * "[platform name]-[8 character lowercase alpha numeric string]".
     *
     * @return string the account name.
     */
    public function getName()
    {
        return $this->name;
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
     * Sets the store currency ISO (ISO 4217) code.
     *
     * @param string $code the currency ISO code.
     */
    public function setCurrencyCode($code)
    {
        $this->currencyCode = $code;
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
     * Sets the store language ISO (ISO 639-1) code.
     *
     * @param string $languageCode the language ISO code.
     */
    public function setLanguageCode($languageCode)
    {
        $this->languageCode = $languageCode;
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
     * Sets the owner language ISO (ISO 639-1) code.
     *
     * @param string $language_code the language ISO code.
     */
    public function setOwnerLanguageCode($language_code)
    {
        $this->ownerLanguageCode = $language_code;
    }

    /**
     * The 2-letter ISO code (ISO 639-1) for the language of the account owner
     * who is creating the account.
     *
     * @return string the language ISO code.
     */
    public function getOwnerLanguageCode()
    {
        return $this->ownerLanguageCode;
    }

    /**
     * Meta data model for the account owner who is creating the account.
     *
     * @return NostoTaggingMetaAccountOwner the meta data model.
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Meta data model for the account billing details.
     *
     * @return NostoTaggingMetaAccountBilling the meta data model.
     */
    public function getBillingDetails()
    {
        return $this->billing;
    }

    /**
     * Returns an array of currencies used for this account
     *
     * @return array
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }

    /**
     * Sets the currencies
     *
     * @param $currencies
     */
    public function setCurrencies($currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * Setter for useCurrencyExhangeRates
     *
     * @param boolean $useCurrencyExchangeRates
     */
    public function setUseCurrencyExchangeRates($useCurrencyExchangeRates)
    {
        $this->useCurrencyExchangeRates = $useCurrencyExchangeRates;
    }

    /**
     * Returns if the exchange rates are used
     *
     * @return boolean
     */
    public function getUseCurrencyExchangeRates()
    {
        return $this->useCurrencyExchangeRates;
    }

    /**
     * Sets the default variation id
     * @param string $defaultVariationId
     */
    public function setDefaultVariationId($defaultVariationId)
    {
        $this->defaultVariationId = $defaultVariationId;
    }

    /**
     * Return the default variation id
     *
     * @return string
     */
    public function getDefaultVariationId()
    {
        return $this->defaultVariationId;
    }

    /**
     * Sets the details
     * @param string $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * Returns the account details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Returns the partner code
     *
     * @return string
     */
    public function getPartnerCode()
    {
        return $this->partnerCode;
    }

    /**
     * Returns the name of the platform
     *
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Returns the signup api token
     *
     * @return string
     */
    public function getSignupApiToken()
    {
        return $this->signupApiToken;
    }
}
