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
class NostoOperationExchangeRate
{
    /**
     * @var NostoAccountInterface the Nosto account to update the rates for.
     */
    protected $account;

    /**
     * @var NostoExchangeRateCollection collection of exchange rates to be updated
     */
    protected $collection;

    /**
     * Constructor.
     *
     * Accepts the Nosto account for which the service is to operate on.
     *
     * @param NostoAccountInterface $account the Nosto account object.
     * @param NostoExchangeRateCollection $collection the Nosto account object.
     */
    public function __construct(
        NostoAccountInterface $account,
        NostoExchangeRateCollection $collection
    ) {
        $this->account = $account;
        $this->collection = $collection;
    }

    /**
     * Updates exchange rates to Nosto
     * @return bool
     * @throws NostoException
     */
    public function update()
    {
        $request = $this->initApiRequest();
        $response = $request->post($this->getCollectionAsJson());
        if ($response->getCode() !== 200) {
            Nosto::throwHttpException(
                sprintf(
                    'Failed to update currencyCode exchange rates for account %s.',
                    $this->account->getName()
                ),
                $request,
                $response
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
        $token = $this->account->getApiToken(NostoApiToken::API_EXCHANGE_RATES);
        if (is_null($token)) {
            Nosto::throwException(
                sprintf(
                    'No `%s` API token found for account "%s".',
                    NostoApiToken::API_EXCHANGE_RATES,
                    $this->account->getName()
                )
            );
        }
        $request = new NostoApiRequest();
        $request->setContentType('application/json');
        $request->setAuthBasic('', $token->getValue());
        $request->setPath(NostoApiRequest::PATH_CURRENCY_EXCHANGE_RATE);
        return $request;
    }

    /**
     * Turn the currencyCode exchange rate collection into a JSON structure.
     *
     * Format:
     *
     * {
     *   "rates": {
     *     "EUR": {
     *       "rate": "0.706700000000",
     *       "price_currency_code": "EUR"
     *     }
     *   },
     *   "valid_until": "2015-02-27T12:00:00Z"
     * }
     *
     * @return string the JSON structure.
     * @throws NostoException of the rate collection is empty.
     */
    protected function getCollectionAsJson()
    {
        $data = array(
            'rates' => array(),
            'valid_until' => null,
        );

        /** @var NostoExchangeRate $item */
        foreach ($this->collection as $item) {
            $data['rates'][$item->getName()] = array(
                'rate' => $item->getExchangeRate(),
                'price_currency_code' => $item->getCurrencyCode(),
            );
        }
        if (empty($data['rates'])) {
            Nosto::throwException(
                sprintf(
                    'Failed to update currencyCode exchange rates for account %s. No rates found in collection.',
                    $this->account->getName()
                )
            );
        }
        return json_encode($data);
    }
}
