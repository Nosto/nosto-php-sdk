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
     * @var NostoAccountInterface the Nosto account to update the rates for.
     */
    protected $account;

    /**
     * @var NostoAccountMetaDataInterface Nosto account meta
     */
    protected $accountMeta;

    /**
     * Constructor.
     *
     * Accepts the Nosto account for which the service is to operate on.
     *
     * @param NostoAccountInterface $account the Nosto account object.
     * @param NostoAccountMetaDataInterface $accountMeta the Nosto account object.
     */
    public function __construct(
        NostoAccountInterface $account,
        NostoAccountMetaDataInterface $accountMeta
    ) {
        $this->account = $account;
        $this->accountMeta = $accountMeta;
    }

    /**
     * Updates account settings to Nosto
     * @return bool
     * @throws NostoException
     */
    public function update()
    {
        $request = $this->initApiRequest();
        $response = $request->put($this->getSettingsJson());
        if ($response->getCode() !== 200) {
            throw new NostoException(
                sprintf(
                    'Update error for account %s: %s',
                    $this->account->getName(),
                    $response->getMessage()
                )
            );
        }
        return true;
    }

    /**
     * Builds the API request and returns it.
     *
     * @return NostoApiRequest the request object.
     * @throws NostoException if the request object cannot be built.
     */
    protected function initApiRequest()
    {
        $token = $this->account->getApiToken(NostoApiToken::API_SETTINGS);
        if (is_null($token)) {
            throw new NostoException(
                sprintf(
                    'No `%s` API token found for account "%s".',
                    NostoApiToken::API_SETTINGS,
                    $this->account->getName()
                )
            );
        }
        $request = new NostoApiRequest();
        $request->setContentType('application/json');
        $request->setAuthBasic('', $token->getValue());
        $request->setPath(NostoApiRequest::PATH_SETTINGS);
        return $request;
    }
    /**
     * Returns the settings in JSON format
     *
     * @return string the JSON structure.
     */
    protected function getSettingsJson()
    {
        $data = array(
            'title' => $this->accountMeta->getTitle(),
            'front_page_url' => $this->accountMeta->getFrontPageUrl(),
            'currency_code' => $this->accountMeta->getCurrencyCode(),
        );

        // Currencies and currency options
        $currencyCount = count($this->accountMeta->getCurrencies());
        if ($currencyCount > 0) {
            $data['currencies'] = array();
            foreach ($this->accountMeta->getCurrencies() as $currency) {
                $data['currencies'][$currency->getCode()->getCode()] = array(
                    'currency_before_amount' => (
                        $currency->getSymbol()->getPosition() === NostoCurrencySymbol::SYMBOL_POS_LEFT
                    ),
                    'currency_token' => $currency->getSymbol()->getSymbol(),
                    'decimal_character' => $currency->getFormat()->getDecimalSymbol(),
                    'grouping_separator' => $currency->getFormat()->getGroupSymbol(),
                    'decimal_places' => $currency->getFormat()->getPrecision(),
                );
            }
        }
        $data['use_exchange_rates'] = $this->accountMeta->getUseCurrencyExchangeRates();
        if ($this->accountMeta->getDefaultVariationId()) {
            $data['default_variant_id'] = $this->accountMeta->getDefaultVariationId();
        } else {
            $data['default_variant_id'] = '';
        }

        return json_encode($data);
    }
}
