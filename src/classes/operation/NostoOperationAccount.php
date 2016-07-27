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
class NostoOperationAccount extends NostoOperation
{
    /**
     * @var NostoSignupInterface Nosto account meta
     */
    private $account;

    /**
     * Constructor.
     *
     * Accepts the Nosto account for which the service is to operate on.
     *
     * @param NostoSignupInterface $account the Nosto account object.
     */
    public function __construct(NostoSignupInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Sends a POST request to create a new account for a store in Nosto
     *
     * @return NostoAccountInterface if the request was successful.
     * @throws NostoException on failure.
     */
    public function create()
    {
        $request = $this->initApiRequest($this->account->getSignUpApiToken());
        $request->setPath(NostoApiRequest::PATH_SIGN_UP);
        $request->setReplaceParams(array('{lang}' => $this->account->getLanguageCode()));
        $response = $request->post($this->getJson());
        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Failed to create Nosto account.', $request, $response);
        }

        $config = new NostoAccount($this->account->getPlatform() . '-' . $this->account->getName());
        $config->setTokens(NostoApiToken::parseTokens($response->getJsonResult(true), '', '_token'));
        return $config;
    }

    /**
     * Returns the account in JSON format
     *
     * @return string the JSON structure.
     */
    protected function getJson()
    {
        $data = array(
            'title' => $this->account->getTitle(),
            'name' => $this->account->getName(),
            'platform' => $this->account->getPlatform(),
            'front_page_url' => $this->account->getFrontPageUrl(),
            'currency_code' => strtoupper($this->account->getCurrencyCode()),
            'language_code' => strtolower($this->account->getOwnerLanguageCode()),
            'owner' => array(
                'first_name' => $this->account->getOwner()->getFirstName(),
                'last_name' => $this->account->getOwner()->getLastName(),
                'email' => $this->account->getOwner()->getEmail(),
            ),
            'api_tokens' => array(),
        );

        // Add optional billing details if the required data is set.
        $billingDetails = array(
            'country' => strtoupper($this->account->getBillingDetails()->getCountry())
        );
        if (!empty($billingDetails['country'])) {
            $data['billing_details'] = $billingDetails;
        }

        // Add optional partner code if one is set.
        $partnerCode = $this->account->getPartnerCode();
        if (!empty($partnerCode)) {
            $data['partner_code'] = $partnerCode;
        }

        // Request all available API tokens for the account.
        foreach (NostoApiToken::$tokenNames as $name) {
            $data['api_tokens'][] = 'api_' . $name;
        }

        if ($this->account->getDetails()) {
            $data['details'] = $this->account->getDetails();
        }

        $data['use_exchange_rates'] = $this->account->getUseCurrencyExchangeRates();
        if ($this->account->getDefaultVariationId()) {
            $data['default_variant_id'] = $this->account->getDefaultVariationId();
        }

        return json_encode($data);
    }
}
