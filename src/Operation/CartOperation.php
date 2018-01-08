<?php
/**
 * Copyright (c) 2018, Nosto Solutions Ltd
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
 * @copyright 2018 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Operation;

use Nosto\Helper\SerializationHelper;
use Nosto\NostoException;
use Nosto\Object\Cart\Update;
use Nosto\Request\Api\ApiRequest;
use Nosto\Request\Api\Token;
use Nosto\Types\Signup\AccountInterface;

class CartOperation extends AbstractOperation
{
    /**
     * @var AccountInterface the account to perform the operation on.
     */
    private $account;

    /**
     * Constructor.
     *
     * @param AccountInterface $account the account object.
     */
    public function __construct(AccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Sends a POST request to update the cart
     *
     * @param Update $update the cart changes
     * @param string $nostoCustomerId
     * @param string $accountId merchange id
     * @return bool if the request was successful.
     * @throws NostoException on failure.
     */
    public function updateCart(Update $update, $nostoCustomerId, $accountId)
    {
        $request = $this->initApiRequest($this->account->getApiToken(Token::API_PRODUCTS));
        $request->setPath(ApiRequest::PATH_CART_UPDATE);
        $updateJson = SerializationHelper::serialize($update);
        $data = '{"items":[{"channel":"cartUpdated-'
            . $accountId
            . '-'
            . $nostoCustomerId
            . '","formats":{"json-object":'
            . $updateJson
            . '}}]}';
        $response = $request->postRaw($data);

        return $this->checkResponse($request, $response);
    }
}
