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
 * Meta data class for account related information needed when creating new accounts.
 */
class NostoSignup extends NostoSettings implements NostoSignupInterface
{
    /**
     * @var string the account name.
     */
    private $name;

    /**
     * @var string the owner language ISO (ISO 639-1) code.
     */
    private $ownerLanguageCode;

    /**
     * @var NostoSignupOwnerInterface the account owner meta model.
     */
    private $owner;

    /**
     * @var NostoSignupBillingDetailsInterface the billing meta model.
     */
    private $billing;

    /**
     * @var string details
     */
    private $details = null;

    /**
     * @var NostoApiToken sign up api token
     */
    private $signupApiToken;

    /**
     * @var string platform name
     */
    private $platform;

    /**
     * @var string partner code
     */
    private $partnerCode;

    /**
     * @var array the default set of api tokens
     */
    private $apiTokens;

    /**
     * Constructor
     *
     * @param string $platform
     * @param string $signupApiToken
     * @param string $partnerCode
     */
    public function __construct($platform, $signupApiToken, $partnerCode)
    {
        $this->setPlatform($platform);
        $this->setSignupApiToken(new NostoApiToken(NostoApiToken::API_CREATE, $signupApiToken));
        $this->setPartnerCode($partnerCode);
        $this->addApiToken(NostoApiToken::API_PRODUCTS);
        $this->addApiToken(NostoApiToken::API_SSO);
        $this->addApiToken(NostoApiToken::API_EXCHANGE_RATES);
        $this->addApiToken(NostoApiToken::API_SETTINGS);
    }

    /**
     * Sets the API tokens
     * @param $apiToken string the name of the API scope
     */
    public function addApiToken($apiToken)
    {
        $this->apiTokens[] = strtoupper('api_' . $apiToken);
    }

    /**
     * Sets the account billing details.
     *
     * @param $billingDetails NostoSignupBillingDetailsInterface the account billing details
     */
    public function setBillingDetails(NostoSignupBillingDetailsInterface $billingDetails)
    {
        $this->billing = $billingDetails;
    }

    /**
     * Returns the signup api token
     *
     * @return NostoApiToken
     */
    public function getSignupApiToken()
    {
        return $this->signupApiToken;
    }

    /**
     * @param NostoApiToken $signupApiToken
     */
    public function setSignupApiToken(NostoApiToken $signupApiToken)
    {
        $this->signupApiToken = $signupApiToken;
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
     * Sets the account name.
     *
     * @param string $name the account name.
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @param string $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
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
     * Sets the owner language ISO (ISO 639-1) code.
     *
     * @param string $language_code the language ISO code.
     */
    public function setOwnerLanguageCode($language_code)
    {
        $this->ownerLanguageCode = $language_code;
    }

    /**
     * Meta data model for the account owner who is creating the account.
     *
     * @return NostoSignupOwnerInterface the meta data model.
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Sets the account owner who is creating the account.
     *
     * @param $owner NostoSignupOwnerInterface the account owner
     */
    public function setOwner(NostoSignupOwnerInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * Meta data model for the account billing details.
     *
     * @return NostoSignupBillingDetailsInterface the meta data model.
     */
    public function getBillingDetails()
    {
        return $this->billing;
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
     * @param string $partnerCode
     */
    public function setPartnerCode($partnerCode)
    {
        $this->partnerCode = $partnerCode;
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
     * Sets the details
     * @param string $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * Returns the API tokens
     */
    public function getApiTokens()
    {
        return $this->apiTokens;
    }
}
