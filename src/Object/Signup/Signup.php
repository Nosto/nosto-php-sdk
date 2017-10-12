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

namespace Nosto\Object\Signup;

use Nosto\Object\Settings;
use Nosto\Request\Api\Token;
use Nosto\Types\Signup\BillingInterface;
use Nosto\Types\Signup\OwnerInterface;
use Nosto\Types\Signup\SignupInterface;
use stdClass;

/**
 * Model class for containing information used when creating an account. This
 * information along with the account settings are used to configure the Nosto account
 */
class Signup extends Settings implements SignupInterface
{
    /**
     * @var string the unique identifier used for denoting the account
     */
    private $name;

    /**
     * @var string the owner language ISO (ISO 639-1) code.
     */
    private $ownerLanguageCode;

    /**
     * @var OwnerInterface the account owner meta model.
     */
    private $owner;

    /**
     * @var BillingInterface the billing meta model.
     */
    private $billing;

    /**
     * @var array|stdClass details
     */
    private $details = null;

    /**
     * @var Token the account creation API token used for opening accounts
     */
    private $signupApiToken;

    /**
     * @var string the simple name of the platform opening the account as given
     */
    private $platform;

    /**
     * @var string|null a partner code for revenue attribution if one has been given
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
    public function __construct($platform, $signupApiToken, $partnerCode = null)
    {
        $this->setPlatform($platform);
        $this->setSignupApiToken(new Token(Token::API_CREATE, $signupApiToken));
        $this->setPartnerCode($partnerCode);
        $this->addApiToken(Token::API_PRODUCTS);
        $this->addApiToken(Token::API_SSO);
        $this->addApiToken(Token::API_EXCHANGE_RATES);
        $this->addApiToken(Token::API_SETTINGS);
    }

    /**
     * Set the list of API tokens that should be granted when creating the account.
     * Depending upon the different endpoints that need to be access, the different
     * scopes must be requested. For example, in OrderConfirm to use the API to upsert
     * products, you must add the scope `products`. Scopes must be specified without
     * the leading API_ prefix.
     *
     * @param $apiToken string the name of the API scope
     */
    public function addApiToken($apiToken)
    {
        $this->apiTokens[] = strtoupper('api_' . $apiToken);
    }

    /**
     * Sets the billing details for the account to opened. The billing details
     * primarily contain the country code used for deciding the charging currency i.e.
     * EUR or USD
     *
     * @param $billingDetails BillingInterface the billing details
     */
    public function setBillingDetails(BillingInterface $billingDetails)
    {
        $this->billing = $billingDetails;
    }

    /**
     * @inheritdoc
     */
    public function getSignupApiToken()
    {
        return $this->signupApiToken;
    }

    /**
     * Sets the account creation API token used for opening account. This token is
     * unique for every platform and is issued by Nosto. This key is assumed to be
     * public and therefore can bundled into the implementation source code.
     *
     * @param Token $signupApiToken
     */
    public function setSignupApiToken(Token $signupApiToken)
    {
        $this->signupApiToken = $signupApiToken;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the unique identifier used for denoting the account. This is normally
     * an 8 character lower-cased random alphanumeric string. The resultant account
     * name is a hyphenated combination of the name of the platform and the specified
     * identifier. e.g. magento-12345678
     *
     * @param string $name the account name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Sets the name of the platform using the SDK for opening an account. This is
     * the normalized and lower-cased name of the platform for bootstrapping the new
     * account with platform-specific configuration.
     *
     * @param string $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Sets the account owner who is creating the account.
     *
     * @param $owner OwnerInterface the account owner
     */
    public function setOwner(OwnerInterface $owner)
    {
        $this->owner = $owner;
    }

    /**
     * @inheritdoc
     */
    public function getBillingDetails()
    {
        return $this->billing;
    }

    /**
     * @inheritdoc
     */
    public function getPartnerCode()
    {
        return $this->partnerCode;
    }

    /**
     * Sets the partner code for revenue attribution if one has been given. If
     * no partner code is specified, this may be omitted.
     *
     * @param string|null $partnerCode
     */
    public function setPartnerCode($partnerCode)
    {
        $this->partnerCode = $partnerCode;
    }

    /**
     * @inheritdoc
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Sets the details
     * @param array|stdClass $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @inheritdoc
     */
    public function getApiTokens()
    {
        return $this->apiTokens;
    }
}
