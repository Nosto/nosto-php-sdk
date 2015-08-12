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
 * Nosto account class for handling account related actions like, creation, OAuth2 syncing and SSO to Nosto.
 */
class NostoAccount
{
    /**
     * @var string the name of the Nosto account.
     */
    protected $name;

    /**
     * @var NostoApiToken[] the Nosto API tokens associated with this account.
     */
    protected $tokens = array();

    /**
     * Constructor.
     * Create a new account object with given name.
     *
     * @param $name
     *
     * @throws NostoInvalidArgumentException
     */
    public function __construct($name)
    {
        if (!is_string($name) || empty($name)) {
            throw new NostoInvalidArgumentException(sprintf(
                '%s.name (%s) must be a non-empty string value.',
                __CLASS__,
                $name
            ));
        }

        $this->name = (string)$name;
    }

    /**
     * Creates a new Nosto account with the specified data.
     *
     * @param NostoAccountMetaInterface $meta the account data model.
     * @return NostoAccount the newly created account.
     *
     * @throws NostoException if the account cannot be created.
     */
    public static function create(NostoAccountMetaInterface $meta)
    {
        $params = array(
            'title' => $meta->getTitle(),
            'name' => $meta->getName(),
            'platform' => $meta->getPlatform(),
            'front_page_url' => $meta->getFrontPageUrl(),
            'currency_code' => $meta->getCurrency()->getCode(),
            'language_code' => $meta->getOwnerLanguage()->getCode(),
            'owner' => array(
                'first_name' => $meta->getOwner()->getFirstName(),
                'last_name' => $meta->getOwner()->getLastName(),
                'email' => $meta->getOwner()->getEmail(),
            ),
            'api_tokens' => array(),
            'currencies' => array(),
        );

        // Add optional billing details if the required data is set.
        if ($meta->getBillingDetails()->getCountry()) {
            $params['billing_details'] = array(
                'country' => $meta->getBillingDetails()->getCountry()->getCode()
            );
        }

        // Add optional partner code if one is set.
        $partnerCode = $meta->getPartnerCode();
        if (!empty($partnerCode)) {
            $params['partner_code'] = $partnerCode;
        }

        // Request all available API tokens for the account.
        foreach (NostoApiToken::$tokenNames as $name) {
            $params['api_tokens'][] = 'api_'.$name;
        }

        // Add all configured currency formats.
        $currencies = $meta->getCurrencies();
        foreach ($meta->getCurrencies() as $currency) {
            $params['currencies'][$currency->getCode()->getCode()] = array(
                'currency_before_amount' => ($currency->getSymbol()->getPosition() === NostoCurrencySymbol::SYMBOL_POS_LEFT),
                'currency_token' => $currency->getSymbol()->getSymbol(),
                'decimal_character' => $currency->getFormat()->getDecimalSymbol(),
                'grouping_separator' => $currency->getFormat()->getGroupSymbol(),
                'decimal_places' => $currency->getFormat()->getPrecision(),
            );
        }
        if (count($currencies) > 1) {
            $params['default_variant_id'] = $meta->getDefaultPriceVariationId();
            $params['use_exchange_rates'] = (bool)$meta->getUseCurrencyExchangeRates();
        }

        $request = new NostoApiRequest();
        $request->setPath(NostoApiRequest::PATH_SIGN_UP);
        $request->setReplaceParams(array('{lang}' => $meta->getLanguage()->getCode()));
        $request->setContentType('application/json');
        $request->setAuthBasic('', $meta->getSignUpApiToken());
        $response = $request->post(json_encode($params));

        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Nosto account could not be created.', $request, $response);
        }

        $account = new self($meta->getPlatform().'-'.$meta->getName());
        $account->tokens = NostoApiToken::parseTokens($response->getJsonResult(true), '', '_token');
        return $account;
    }

    /**
     * Syncs an existing Nosto account via Oauth2.
     * Requires that the oauth cycle has already completed the first step in getting the authorization code.
     *
     * @param NostoOauthClientMetaInterface $meta the oauth2 client meta data to use for connection to Nosto.
     * @param string $code the authorization code that grants access to transfer data from nosto.
     * @return NostoAccount the synced account.
     *
     * @throws NostoException if the account cannot be synced.
     */
    public static function syncFromNosto(NostoOauthClientMetaInterface $meta, $code)
    {
        $oauthClient = new NostoOAuthClient($meta);
        $token = $oauthClient->authenticate($code);

        if (empty($token->accessToken)) {
            throw new NostoException('No access token found when trying to sync account from Nosto');
        }
        if (empty($token->merchantName)) {
            throw new NostoException('No merchant name found when trying to sync account from Nosto');
        }

        $request = new NostoHttpRequest();
        // The request is currently not made according the the OAuth2 spec with the access token in the
        // Authorization header. This is due to the authentication server not implementing the full OAuth2 spec yet.
        $request->setUrl(NostoOAuthClient::$baseUrl.'/exchange');
        $request->setQueryParams(array('access_token' => $token->accessToken));
        $response = $request->get();
        $result = $response->getJsonResult(true);

        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Failed to sync account from Nosto.', $request, $response);
        }
        if (empty($result)) {
            throw new NostoException('Received invalid data from Nosto when trying to sync account');
        }

        $account = new self($token->merchantName);
        $account->tokens = NostoApiToken::parseTokens($result, 'api_');
        if (!$account->isConnectedToNosto()) {
            throw new NostoException('Failed to sync all account details from Nosto');
        }
        return $account;
    }

    /**
     * Notifies Nosto that an account has been deleted.
     *
     * @throws NostoException if the API request to Nosto fails.
     */
    public function delete()
    {
        $token = $this->getApiToken(NostoApiToken::API_SSO);
        if ($token === null) {
            throw new NostoException('Failed to notify Nosto about deleted account, no "sso" token');
        }

        $request = new NostoHttpRequest();
        $request->setUrl(NostoHttpRequest::$baseUrl.NostoHttpRequest::PATH_ACCOUNT_DELETED);
        $request->setAuthBasic('', $token->getValue());
        $response = $request->post('');

        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Failed to notify Nosto about deleted account.', $request, $response);
        }
    }

    /**
     * Checks if this account is the same as the given account.
     * They are considered equal if their name property match. The tokens are not relevant in the comparison,
     * as they are not required by the account upon creation.
     *
     * @param NostoAccount $account the account to check.
     * @return bool true if equals.
     */
    public function equals(NostoAccount $account)
    {
        return $account->getName() === $this->getName();
    }

    /**
     * Gets the account name.
     *
     * @return string the account name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the accounts API tokens.
     *
     * @return NostoApiToken[] the tokens.
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Checks if this account has been connected to Nosto, i.e. all API tokens exist.
     *
     * @return bool true if it is connected, false otherwise.
     */
    public function isConnectedToNosto()
    {
        $missingTokens = $this->getMissingScopes();
        return empty($missingTokens);
    }

    /**
     * Returns a list of API token names that are present for the account.
     * The API tokens act as scopes when doing OAuth requests to Nosto.
     *
     * @return array the list of names.
     */
    public function getMissingScopes()
    {
        $allTokens = NostoApiToken::getApiTokenNames();
        $foundTokens = array();
        foreach ($allTokens as $tokenName) {
            foreach ($this->tokens as $token) {
                if ($token->getName() === $tokenName) {
                    $foundTokens[] = $tokenName;
                    break;
                }
            }
        }
        return array_diff($allTokens, $foundTokens);
    }

    /**
     * Adds an API token to the account.
     *
     * @param NostoApiToken $token the token.
     */
    public function addApiToken(NostoApiToken $token)
    {
        $this->tokens[] = $token;
    }

    /**
     * Gets an api token associated with this account by it's name , e.g. "sso".
     *
     * @param string $name the api token name.
     * @return NostoApiToken|null the token or null if not found.
     */
    public function getApiToken($name)
    {
        foreach ($this->tokens as $token) {
            if ($token->getName() === $name) {
                return $token;
            }
        }
        return null;
    }

    /**
     * Signs the user in to Nosto via SSO.
     * Requires that the account has a valid sso token associated with it.
     *
     * @param NostoAccountMetaIframeInterface $meta the iframe meta data model.
     * @return string a secure login url that can be used for example to build the config iframe url.
     *
     * @throws NostoException if SSO fails.
     */
    public function ssoLogin(NostoAccountMetaIframeInterface $meta)
    {
        $token = $this->getApiToken(NostoApiToken::API_SSO);
        if (is_null($token)) {
            throw new NostoException(sprintf('No `%s` API token found for account "%s".', NostoApiToken::API_SSO, $this->getName()));
        }

        $request = new NostoHttpRequest();
        $request->setUrl(NostoHttpRequest::$baseUrl.NostoHttpRequest::PATH_SSO_AUTH);
        $request->setReplaceParams(
            array(
                '{platform}' => $meta->getPlatform(),
                '{email}' => $meta->getEmail(),
            )
        );
        $request->setContentType('application/x-www-form-urlencoded');
        $request->setAuthBasic('', $token->getValue());
        $response = $request->post(
            http_build_query(
                array(
                    'fname' => $meta->getFirstName(),
                    'lname' => $meta->getLastName(),
                )
            )
        );
        $result = $response->getJsonResult();

        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Unable to login employee to Nosto with SSO token.', $request, $response);
        }
        if (empty($result->login_url)) {
            throw new NostoException('No "login_url" returned when logging in employee to Nosto');
        }

        return $result->login_url;
    }
}
