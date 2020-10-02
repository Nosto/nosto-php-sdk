<?php
/**
 * Copyright (c) 2020, Nosto Solutions Ltd
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
 * @copyright 2020 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Operation\Order;

use Nosto\Result\Graphql\Order\OrderCreateResultHandler;
use Nosto\Types\Order\BuyerInterface;
use Nosto\Types\Order\OrderInterface;
use Nosto\Operation\AbstractGraphQLOperation;
use Nosto\Types\Signup\AccountInterface;
use Nosto\Helper\SerializationHelper;

/**
 * Operation class for sending orders when created
 * @phan-file-suppress PhanUnreferencedUseNormal
 */
class OrderCreate extends AbstractGraphQLOperation
{

    /** @var OrderInterface */
    private $order;

    /** @var string */
    private $identifierMethod;

    /** @var string */
    private $identifierString;

    /**
     * OrderCreate constructor.
     * @param OrderInterface $order
     * @param AccountInterface $account
     * @param string $identifierMethod
     * @param string $identifierString
     * @param string $activeDomain
     */
    public function __construct(
        OrderInterface $order,
        AccountInterface $account,
        $identifierMethod = self::IDENTIFIER_BY_CID,
        $identifierString = '',
        $activeDomain = ''
    ) {
        $this->order = $order;
        $this->identifierMethod = $identifierMethod;
        $this->identifierString = $identifierString;
        parent::__construct($account, $activeDomain);
    }

    /**
     * @return BuyerInterface|null
     */
    public function getCustomer()
    {
        return $this->order->getCustomer();
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
		foreach ($items as $item) {
		    $itemsArray[] = SerializationHelper::toAssocArray($item);
        }
        return $itemsArray;
    }

    /**
     * @inheritdoc
     */
    protected function getResultHandler()
    {
        return new OrderCreateResultHandler();
    }


    /**
     * @return string
     */
    public function getQuery()
    {
        return <<<QUERY
            mutation(
                \$by: LookupParams!,
                \$customerIdentifier: String!
                \$firstname:String,
                \$lastname: String,
                \$email: String,
                \$marketingPermission: Boolean,
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
            }
QUERY;
    }

    /**
     * @return array|mixed
     */
    public function getVariables()
    {
        $array = [
            'by' => $this->identifierMethod,
            'customerIdentifier' => $this->identifierString,
            'orderNumber' => $this->getOrderNumber(),
            'orderStatus' => $this->getStatusCode(),
            'paymentProvider' => $this->getPaymentProvider(),
            'ref' => $this->getOrderReference(),
            'purchasedItems' => $this->getPurchasedItems(),
        ];
        $buyer = $this->getCustomer();
        if ($buyer !== null) {
            $array = array_merge($array, [
                'firstname' => $buyer->getFirstName(),
                'lastname' => $buyer->getLastName(),
                'email' => $buyer->getEmail(),
                'marketingPermission' => $buyer->getMarketingPermission()
            ]);
        }
        return $array;
    }
}
