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
use Nosto\Operation\AbstractGraphQLOperation;

class OrderCreate extends AbstractGraphQLOperation
{
    const IDENTIFIER_BY_ID = 'BY_CID';
    const IDENTIFIER_BY_REF = 'BY_REF';

    /** @var OrderInterface */
    private $order;

    /** @var string */
    protected $identifierMethod;

    /** @var string */
    protected $customerIdentifier;

    public function execute()
    {
        $response =  parent::execute();
        return true;
    }

    /**
     * @throws NostoException
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
    }

    /**
     * @return BuyerInterface
     */
    public function getCustomer()
    {
        return $this->order->getCustomer();
    }

    /**
     * @return string
     */
    public function getCustomerFirstName()
    {
        return $this->getCustomer()->getFirstName();
    }

    /**
     * @return string
     */
    public function getCustomerLastName()
    {
        return $this->getCustomer()->getLastName();
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->getCustomer()->getEmail();
    }

    /**
     * @return bool
     */
    public function getCustomerMarketingPermission()
    {
        return $this->getCustomer()->getMarketingPermission();
    }

    /**
     * @return int|string
     */
    public function getOrderNumber()
    {
        return $this->order->getOrderNumber();
    }

    /**
     * @return string
     */
    public function getOrderReference()
    {
        return $this->order->getExternalOrderRef();
    }

    /**
     * @return string
     */
    public function getPaymentProvider()
    {
        return $this->order->getPaymentProvider();
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->order->getOrderStatusCode();
    }


    public function getPurchasedItems()
    {
        $items = $this->order->getPurchasedItems();

        $itemsArray = [];
        /** @var LineItemInterface $item */
        foreach ($items as $item) {
            $itemsArray[] = PurchasedItem::toArray($item);
        }
        return $itemsArray;
    }

    /**
     * @param string $identifierMethod
     */
    public function setIdentifierMethod($identifierMethod)
    {
        $this->identifierMethod = $identifierMethod;
    }

    /**
     * @return string
     */
    public function getIdentifierMethod()
    {
        return $this->identifierMethod;
    }

    /**
     * @param string $customerIdentifier
     */
    public function setCustomerIdentifier($customerIdentifier)
    {
        $this->customerIdentifier = $customerIdentifier;
    }

    /**
     * @return string
     */
    public function getCustomerIdentifier()
    {
        return $this->customerIdentifier;
    }

    public function getQuery()
    {
        $query =
            <<<QUERY
        {
            "query":"mutation(
                \$by: LookupParams!,
                \$customerIdentifier: String!
                \$firstname:String!,
                \$lastname: String!,
                \$email: String!,
                \$marketingPermission: Boolean!,
                \$orderNumber: String!,
                \$orderStatus: String!,
                \$paymentProvider: String!,
                \$ref: String!,
                \$purchasedItems:[InputItem]!
            ){
                 placeOrder(
                    by: \$by,
                    id: \$customerIdentifier,
                    params: {
                        customer: {
                            firstName: \$firstname
                            lastName: \$lastname
                            email: \$email
                            marketingPermission: \$marketingPermission
                        }
                        order: {
                            number: \$orderNumber
                            orderStatus: \$orderStatus
                            paymentProvider: \$paymentProvider
                            ref: \$ref
                            purchasedItems: \$purchasedItems
                        }
                    } 
                 )
                 {
                    id
                 }
             }"
        }
QUERY;
        return $query;

    }

    /**
     * @return array|mixed
     */
    public function getVariables()
    {
        $array = [
            'by' => $this->identifierMethod,
            'customerIdentifier' => $this->customerIdentifier,
            'firstname' => $this->getCustomerFirstName(),
            'lastname' => $this->getCustomerLastName(),
            'email' => $this->getCustomerEmail(),
            'marketingPermission' => $this->getCustomerMarketingPermission(),
            'orderNumber' => $this->getOrderNumber(),
            'orderStatus' => $this->getStatusCode(),
            'paymentProvider' => $this->getPaymentProvider(),
            'ref' => $this->getOrderReference(),
            'purchasedItems' => $this->getPurchasedItems(),
        ];

        return ['variables' => $array];
    }
}
