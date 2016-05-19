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
     * The name of the platform the account is used on.
     * A list of valid platform names is issued by Nosto.
     *
     * @return string the platform names.
     */
    abstract public function getPlatform();

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
     * The API token used to identify an account creation.
     * This token is platform specific and issued by Nosto.
     *
     * @return string the API token.
     */
    abstract public function getSignUpApiToken();

    /**
     * Returns the partner code
     *
     * @return string
     */
    abstract public function getPartnerCode();

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


    /*
     * Returns the default variation id
     *
     * @return string
     */
    /**
     * @return string
     */
    public function getDefaultVariationId()
    {
        return $this->defaultVariationId;
    }
}
