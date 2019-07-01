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

use Nosto\Operation\Recommendation\AbstractOperation;
use Nosto\Object\Order\Order as NostoOrder;
use Nosto\Types\Signup\AccountInterface;

/**
 * Operation class for sending order status updates
 */
class OrderStatus extends AbstractOperation
{
    /* @var NostoOrder $order */
    private $nostoOrder;

    /**
     * OrderStatus constructor.
     * @param AccountInterface $account
     * @param NostoOrder $nostoOrder
     */
    public function __construct(
        AccountInterface $account,
        NostoOrder $nostoOrder
    ) {
        parent::__construct($account);
        $this->setOrder($nostoOrder);
    }

    /**
     * @inheritdoc
     */
    public function getQuery()
    {
        $query
            = <<<QUERY
    {
        "query": "mutation(
                \$orderNumber: String!,
                \$orderStatus: String!,
                \$paymentProvider: String!
                \$statusDate: LocalDateTime!
        ) { 
            updateStatus(number: \$orderNumber, params: {
                orderStatus: \$orderStatus
                paymentProvider: \$paymentProvider
                statusDate: \$statusDate
            }) {
                number
                statuses {
                    date
                    orderStatus
                    paymentProvider
                }
            }
        }",
        "variables": {
            "orderNumber": "%s",
            "orderStatus": "%s",
            "paymentProvider": "%s",
            "statusDate": "%s"
        }
    }
QUERY;
        $formatted = sprintf(
            $query,
            $this->getOrderNumber($this->nostoOrder),
            $this->getOrderStatus($this->nostoOrder),
            $this->getPaymentProvider($this->nostoOrder),
            $this->getStatusDate($this->nostoOrder)
        );

        return $formatted;
    }

    public function getOrderNumber(NostoOrder $nostoOrder)
    {
        return $nostoOrder->getOrderNumber();
    }

    public function getOrderStatus(NostoOrder $nostoOrder)
    {
        return $nostoOrder->getOrderStatusCode();
    }

    public function getPaymentProvider(NostoOrder $nostoOrder)
    {
        return $nostoOrder->getPaymentProvider();
    }

    public function getStatusDate(NostoOrder $nostoOrder)
    {
        return $nostoOrder->getCreatedAt();
    }

    public function getOrder(NostoOrder $nostoOrder)
    {
        return $this->nostoOrder;
    }

    public function setOrder(NostoOrder $nostoOrder)
    {
        $this->nostoOrder = $nostoOrder;
    }
}
