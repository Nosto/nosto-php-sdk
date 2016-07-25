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
 * Handles sending currencyCode exchange rates through the Nosto API.
 */
class NostoOperationAccount
{
    /**
     * @var NostoAccountInterface Nosto account meta
     */
    protected $accountMeta;

    /**
     * Constructor.
     *
     * Accepts the Nosto account for which the service is to operate on.
     *
     * @param NostoAccountInterface $accountMeta the Nosto account object.
     */
    public function __construct(NostoAccountInterface $accountMeta)
    {
        $this->accountMeta = $accountMeta;
    }

    /**
     * Create and returns a new API request object initialized with:
     * - content type
     * - auth token
     *
     * @param NostoApiToken the token to use for the endpoint
     * @return NostoApiRequest the newly created request object.
     * @throws NostoException if the account does not have the `signup` token set.
     */
    protected function initApiRequest(NostoApiToken $token)
    {
        if (is_null($token)) {
            throw new NostoException('No `signup` API token found for account.');
        }

        $request = new NostoApiRequest();
        $request->setContentType('application/json');
        $request->setAuthBasic('', $token->getValue());
        return $request;
    }

    /**
     * Sends a POST request to create a new account for a store in Nosto
     *
     * @return NostoConfigurationInterface if the request was successful.
     * @throws NostoException on failure.
     */
    public function create()
    {
        $request = $this->initApiRequest($this->accountMeta->getSignUpApiToken());
        $request->setPath(NostoApiRequest::PATH_SIGN_UP);
        $request->setReplaceParams(array('{lang}' => $meta->getLanguageCode()));
        $response = $request->post($this->getJson());
        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Failed to create Nosto account.', $request, $response);
        }

        $config = new NostoConfiguration($meta->getPlatform().'-'.$meta->getName());
        $config->tokens = NostoApiToken::parseTokens($response->getJsonResult(true), '', '_token');
        return $config;
    }

    /**
     * Sends a POST request to delete an account for a store in Nosto
     *
     * @param NostoCo
     * @return bool if the request was successful.
     * @throws NostoException on failure.
     */
    public function delete(NostoConfiguration $config)
    {
        $request = $this->initApiRequest($config->getApiToken('sso'));
        $request->setPath(NostoApiRequest::PATH_ACCOUNT_DELETED);
        $response = $request->post('');
        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Failed to delete Nosto account.', $request, $response);
        }

        return true;
    }

    /**
     * Returns the account in JSON format
     *
     * @return string the JSON structure.
     */
    protected function getJson()
    {
        $data = array(
            'title' => $meta->getTitle(),
            'name' => $meta->getName(),
            'platform' => $meta->getPlatform(),
            'front_page_url' => $meta->getFrontPageUrl(),
            'currency_code' => strtoupper($meta->getCurrencyCode()),
            'language_code' => strtolower($meta->getOwnerLanguageCode()),
            'owner' => array(
                'first_name' => $meta->getOwner()->getFirstName(),
                'last_name' => $meta->getOwner()->getLastName(),
                'email' => $meta->getOwner()->getEmail(),
            ),
            'api_tokens' => array(),
        );

        // Add optional billing details if the required data is set.
        $billingDetails = array(
            'country' => strtoupper($meta->getBillingDetails()->getCountry())
        );
        if (!empty($billingDetails['country'])) {
            $data['billing_details'] = $billingDetails;
        }

        // Add optional partner code if one is set.
        $partnerCode = $meta->getPartnerCode();
        if (!empty($partnerCode)) {
            $data['partner_code'] = $partnerCode;
        }

        // Request all available API tokens for the account.
        foreach (NostoApiToken::$tokenNames as $name) {
            $data['api_tokens'][] = 'api_'.$name;
        }

        if ($meta->getDetails()) {
            $data['details'] = $meta->getDetails();
        }

        $data['use_exchange_rates'] = $meta->getUseCurrencyExchangeRates();
        if ($meta->getDefaultVariationId()) {
            $data['default_variant_id'] = $meta->getDefaultVariationId();
        }

        return json_encode($data);
    }
}
