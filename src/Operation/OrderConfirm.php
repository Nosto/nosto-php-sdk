<?php
/**
 * Copyright (c) 2019, Nosto Solutions Ltd
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
 * @copyright 2019 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Operation;

use Nosto\Request\Api\ApiRequest;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Types\Order\OrderInterface;

/**
 * Handles sending the OrderConfirm confirmations to Nosto via the API.
 *
 * OrderConfirm confirmations can be sent two different ways:
 * - matched orders; where we know the Nosto customer ID of the user who placed the OrderConfirm
 * - un-matched orders: where we do not know the Nosto customer ID of the user who placed the OrderConfirm
 *
 * The second option is a fallback and should be avoided as much as possible.
 */
class OrderConfirm extends AbstractAuthenticatedOperation
{
    /**
     * Sends the OrderConfirm confirmation to Nosto.
     *
     * @param OrderInterface $order the placed OrderConfirm model.
     * @param string|null $customerId the Nosto customer ID of the user who placed the OrderConfirm.
     * @return true on success.
     * @throws AbstractHttpException
     */
    public function send(
        OrderInterface $order,
        $customerId = null,
        $nostoAccount = null,
        $activeDomain = null
    )
    {
        $request = new ApiRequest();
        if (!empty($customerId)) {
            $request->setPath(ApiRequest::PATH_ORDER_TAGGING);
            $replaceParams = array('{m}' => $this->account->getName(), '{cid}' => $customerId);
        } else {
            $request->setPath(ApiRequest::PATH_UNMATCHED_ORDER_TAGGING);
            $replaceParams = array('{m}' => $this->account->getName());
        }
        if (is_string($activeDomain)) {
            $request->setActiveDomainHeader($activeDomain);
        }
        if (is_string($nostoAccount)) {
            $request->setNostoAccountHeader($nostoAccount);
        }
        $request->setReplaceParams($replaceParams);
        $response = $request->post($order);
        return self::checkResponse($request, $response);
    }
}
