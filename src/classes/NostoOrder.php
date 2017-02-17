<?php
/**
 * Copyright (c) 2017, Nosto Solutions Ltd
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
 * @copyright 2017 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

/**
 * Model for order information. This is used when compiling the info about an
 * order that is sent to Nosto.
 */
class NostoOrder extends NostoObject implements NostoOrderInterface, NostoValidatableInterface
{
    /**
     * @var string|int the unique order number identifying the order
     */
    private $orderNumber;

    /**
     * @var string the date when the order was placed in the format Y-m-d
     */
    private $createdDate;

    /**
     * @var string the name of the payment provider used for order
     */
    private $paymentProvider;

    /**
     * @var NostoOrderBuyerInterface the details of the person placing the order
     */
    private $customer;

    /**
     * @var NostoLineItemInterface[] the list of items in the order
     */
    private $purchasedItems = array();

    /**
     * @var string the latest order status of the order
     */
    private $orderStatusCode;

    /**
     * @var string the latest order status of the order
     */
    private $orderStatusLabel;

    /**
     * @var NostoOrderStatusInterface[] the previous order statuses of the order
     */
    private $orderStatuses;

    /**
     * @var string an external order reference used for reporting purposes
     */
    private $externalOrderRef;

    public function __construct()
    {
        // Dummy
    }

    /**
     * @inheritdoc
     */
    public function validationRules()
    {
        return array();
    }

    /**
     * Add a unique purchased item to the order
     *
     * @param NostoLineItemInterface $purchasedItem the purchased item
     */
    public function addPurchasedItems(NostoLineItemInterface $purchasedItem)
    {
        $this->purchasedItems[] = $purchasedItem;
    }

    /**
     * Add an previous order status to the order
     *
     * @param NostoOrderStatusInterface $orderStatus the order status
     */
    public function addOrderStatus(NostoOrderStatusInterface $orderStatus)
    {
        $this->orderStatuses[] = $orderStatus;
    }

    /**
     * @inheritdoc
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Sets the unique order number identifying the order
     *
     * @param string $orderNumber the order number
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @inheritdoc
     */
    public function getExternalOrderRef()
    {
        return $this->externalOrderRef;
    }

    /**
     * Sets the external order reference for the order
     *
     * @param string $externalOrderRef the external order reference
     */
    public function setExternalOrderRef($externalOrderRef)
    {
        $this->externalOrderRef = $externalOrderRef;
    }

    /**
     * @inheritdoc
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Sets the date when the order was placed in the format Y-m-d
     *
     * @param string $createdDate the created date.
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @inheritdoc
     */
    public function getPaymentProvider()
    {
        return $this->paymentProvider;
    }

    /**
     * Sets the name of the payment provider for the order
     *
     * @param string $paymentProvider the payment provider
     */
    public function setPaymentProvider($paymentProvider)
    {
        $this->paymentProvider = $paymentProvider;
    }

    /**
     * @inheritdoc
     */
    public function getOrderStatusCode()
    {
        return $this->orderStatusCode;
    }

    /**
     * @inheritdoc
     */
    public function getOrderStatusLabel()
    {
        return $this->orderStatusLabel;
    }

    /**
     * Sets the latest order status for the order
     *
     * @param NostoOrderStatusInterface $orderStatus the order status
     */
    public function setOrderStatus(NostoOrderStatusInterface $orderStatus)
    {
        $this->orderStatusCode = $orderStatus->getCode();
        $this->orderStatusLabel = $orderStatus->getLabel();
    }

    /**
     * @inheritdoc
     */
    public function getPurchasedItems()
    {
        return $this->purchasedItems;
    }

    /**
     * Sets the purchased items for the order
     *
     * @param NostoLineItemInterface[] $purchasedItems the purchased items
     */
    public function setPurchasedItems(array $purchasedItems)
    {
        $this->purchasedItems = $purchasedItems;
    }

    /**
     * @inheritdoc
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Sets the buyer information for the order
     *
     * @param NostoOrderBuyerInterface $customer the buyer information
     */
    public function setCustomer(NostoOrderBuyerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @inheritdoc
     */
    public function getOrderStatuses()
    {
        $formatted = array();
        if (
            $this->orderStatuses instanceof Traversable
            || is_array($this->orderStatuses)
        ) {
            foreach ($this->orderStatuses as $orderStatus) {
                if (!isset($formatted[$orderStatus->getCode()])) {
                    $formatted[$orderStatus->getCode()] = array();
                }
                $formatted[$orderStatus->getCode()][] = $orderStatus->getDate();
            }
        }

        return $formatted;
    }
}
