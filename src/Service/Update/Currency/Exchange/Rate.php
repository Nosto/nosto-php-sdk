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
 * Handles sending currency exchange rates through the Nosto API.
 */
class NostoServiceUpdateCurrencyExchangeRate
{
    /**
     * Sends a currency exchange rate update request to Nosto via the API.
     *
     * @param NostoAccountInterface $account the account to update the rates for.
     * @param NostoCurrencyExchangeRateCollection $collection the collection of rates to update.
     * @return bool if the update was successful.
     * @throws NostoException if the request cannot be created.
     * @throws NostoHttpException if the request was sent but failed.
     */
    public static function send(NostoAccountInterface $account, NostoCurrencyExchangeRateCollection $collection)
    {
        $request = self::initApiRequest($account);
        $response = $request->post(self::getRatesAsJson($collection));
        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Failed to create Nosto product(s).', $request, $response);
        }
        return true;
    }

    /**
     * Builds the API request and returns it.
     *
     * @param NostoAccountInterface $account the account to get the auth token from.
     * @return NostoApiRequest the request object.
     * @throws NostoException if the request object cannot be built.
     */
    protected static function initApiRequest(NostoAccountInterface $account)
    {
        $token = $account->getApiToken(NostoApiToken::API_CURRENCY);
        if (is_null($token)) {
            throw new NostoException('No `products` API token found for account.');
        }
        $request = new NostoApiRequest();
        $request->setContentType('application/json');
        $request->setAuthBasic('', $token->getValue());
        $request->setPath(NostoApiRequest::PATH_CURRENCY_EXCHANGE_RATE); // todo: change this
        return $request;
    }

    /**
     * Turn the currency exchange rate collection into a JSON structure.
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
     * @param NostoCurrencyExchangeRateCollection $collection the rate collection.
     * @return string the JSON structure.
     */
    protected static function getRatesAsJson(NostoCurrencyExchangeRateCollection $collection)
    {
        $array = array(
            'rates' => array(),
            'valid_until' => !is_null($collection->getValidUntil())
                    ? date('Y-m-d\TH:i:s\Z', $collection->getValidUntil())
                    : null,
        );
        /** @var NostoCurrencyExchangeRate $item */
        foreach ($collection->getArrayCopy() as $item) {
            $array['rates'][$item->getCurrencyCode()] = array(
                'rate' => $item->getExchangeRate(),
                'price_currency_code' => $item->getCurrencyCode(),
            );
        }
        return json_encode($array);
    }
}
