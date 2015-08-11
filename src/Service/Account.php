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
 * Handles sending account update requests though the Nosto API.
 *
 * Account updates are needed when making changes in the platform settings that
 * need to be transferred to Nosto. An example of this would be when a new
 * currency is added and the price formatting details need to be made available
 * in Nosto for the recommendations.
 */
class NostoServiceAccount
{
    /**
     * @var NostoAccountInterface the Nosto account.
     */
    protected $account;

    /**
     * Constructor.
     *
     * Accepts the Nosto account for which the service is to operate on.
     *
     * @param NostoAccountInterface $account the Nosto account object.
     */
    public function __construct(NostoAccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Sends an account update API call to Nosto.
     *
     * @param NostoAccountMetaInterface $meta the account meta data.
     * @return bool true on success.
     *
     * @throws NostoException on failure.
     */
    public function update(NostoAccountMetaInterface $meta)
    {
        $request = $this->initApiRequest();
        $response = $request->put($this->getAccountMetaAsJson($meta));
        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Failed to send account update to Nosto.', $request, $response);
        }
        return true;
    }

    /**
     * Builds the API request and returns it.
     *
     * @return NostoApiRequest the request object.
     *
     * @throws NostoException if `settings` API token cannot be found.
     */
    protected function initApiRequest()
    {
        $token = $this->account->getApiToken(NostoApiToken::API_SETTINGS);
        if (is_null($token)) {
            throw new NostoException(sprintf('No `%s` API token found for account "%s".', NostoApiToken::API_SETTINGS, $this->account->getName()));
        }

        $request = new NostoApiRequest();
        $request->setContentType('application/json');
        $request->setAuthBasic('', $token->getValue());
        $request->setPath(NostoApiRequest::PATH_SETTINGS);

        return $request;
    }

    /**
     * Turns the account meta data into valid JSON that can be sent to Nosto.
     *
     * @param NostoAccountMetaInterface $meta the account meta data.
     * @return string the JSON.
     */
    protected function getAccountMetaAsJson(NostoAccountMetaInterface $meta)
    {
        $data = array(
            'title' => $meta->getTitle(),
            'language_code' => $meta->getLanguage()->getCode(),
            'front_page_url' => $meta->getFrontPageUrl(),
            'currency_code' => $meta->getCurrency()->getCode(),
            'currencies' => array(),
        );

        $currencies = $meta->getCurrencies();
        foreach ($meta->getCurrencies() as $currency) {
            $data['currencies'][$currency->getCode()->getCode()] = array(
                'currency_before_amount' => ($currency->getSymbol()->getPosition() === NostoCurrencySymbol::SYMBOL_POS_LEFT),
                'currency_token' => $currency->getSymbol()->getSymbol(),
                'decimal_character' => $currency->getFormat()->getDecimalSymbol(),
                'grouping_separator' => $currency->getFormat()->getGroupSymbol(),
                'decimal_places' => $currency->getFormat()->getPrecision(),
            );
        }

        if (count($currencies) > 1) {
            $data['default_variant_id'] = $meta->getDefaultPriceVariationId();
            $data['use_exchange_rates'] = (bool)$meta->getUseCurrencyExchangeRates();
        }

        return json_encode($data);
    }
}
