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

namespace Nosto\Operation\Order;

use Nosto\NostoException;
use Nosto\Types\LineItemInterface;
use Nosto\Types\Order\BuyerInterface;
use Nosto\Types\Order\OrderInterface;
use Nosto\Operation\AbstractAuthenticatedOperation;

class OrderCreate extends AbstractAuthenticatedOperation
{
    const IDENTIFIER_BY_ID = 'BY_CID';
    const IDENTIFIER_BY_REF = 'BY_REF';

    /** @var BuyerInterface */
    protected $customer;

    /** @var string */
    protected $orderNumber;

    /** @var string */
    protected $orderReference;

    /** @var string */
    protected $paymentProvider;

    /** @var string */
    protected $statusCode;

    /** @var string */
    protected $purchasedItems;

    /** @var bool */
    protected $marketingPermission;

    /** @var string */
    protected $identifierMethod;

    /** @var string */
    protected $customerIdentifier;

    /**
     * @return \Nosto\Request\Graphql\GraphqlRequest
     * @throws NostoException
     */
    public function initGraphqlRequest()
    {
        $request = parent::initGraphqlRequest();
        $request->setContentType(self::CONTENT_TYPE_APPLICATION_GRAPHQL);
        return $request;
    }

    /**
     * @throws NostoException
     */
    public function setOrder(OrderInterface $order)
    {
        $this->setCustomer($order->getCustomer());
        $this->setOrderNumber($order->getOrderNumber());
        $this->setOrderReference($order->getExternalOrderRef());
        $this->setPaymentProvider($order->getPaymentProvider());
        $this->setStatusCode($order->getOrderStatusCode());
        $this->setPurchasedItems($order->getPurchasedItems());
    }

    /**
     * @param string $identifierMethod
     */
    public function setIdentifierMethod($identifierMethod)
    {
        $this->identifierMethod = $identifierMethod;
    }

    /**
     * @param string $customerIdentifier
     */
    public function setCustomerIdentifier($customerIdentifier)
    {
        $this->customerIdentifier = $customerIdentifier;
    }

    /**
     * @param BuyerInterface $customer
     */
    private function setCustomer(BuyerInterface $customer)
    {
        $this->customer = $customer;
        $this->setMarketingPermissions($customer->getMarketingPermission());
    }

    /**
     * @param string $orderNumber
     */
    private function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @param string $orderReference
     */
    private function setOrderReference($orderReference)
    {
        $this->orderReference = $orderReference;
    }

    /**
     * @param string $paymentProvider
     */
    private function setPaymentProvider($paymentProvider)
    {
        $this->paymentProvider = $paymentProvider;
    }

    /**
     * @param string $statusCode
     */
    private function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param array $item
     */
    private function setPurchasedItems(array $items)
    {
        $purchasedItemString = '';
        /** @var LineItemInterface $item */
        foreach ($items as $item) {
            $purchasedItemString .= PurchasedItem::toGraphqlString($item);
        }
        $this->purchasedItems = $purchasedItemString;
    }

    /**
     * @param bool $marketingPermission
     */
    private function setMarketingPermissions($marketingPermission)
    {
        $this->marketingPermission = $marketingPermission ? 'true' : 'false' ;
    }

    public function getQuery()
    {
        $query = <<<QUERY
            mutation {
                placeOrder(by:{$this->identifierMethod}, id: "{$this->customerIdentifier}", params: {
                    customer: {
                        firstName: "{$this->customer->getFirstName()}"
                        lastName: "{$this->customer->getLastName()}"
                        email: "{$this->customer->getEmail()}"
                        marketingPermission: {$this->marketingPermission}
                    }
                    order: {
                        number: "{$this->orderNumber}"
                        orderStatus: "{$this->statusCode}"
                        paymentProvider: "{$this->paymentProvider}"
                        ref: "{$this->orderReference}"
                        purchasedItems: [
                            {$this->purchasedItems}
                        ]
                    }
                }) {
                    id
                }
            }
QUERY;

    return $query;
    }
}
