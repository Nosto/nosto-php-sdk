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
     * @var string|int the unique order number identifying the order.
     */
    private $orderNumber;

    /**
     * @var string the date when the order was placed.
     */
    private $createdDate;

    /**
     * @var string the payment provider used for order.
     *
     * Formatted according to "[provider name] [provider version]".
     */
    private $paymentProvider;

    /**
     * @var NostoOrderBuyer The user info of the buyer.
     */
    private $buyerInfo;

    /**
     * @var NostoLineItem[] the items in the order.
     */
    private $purchasedItems = array();

    /**
     * @var NostoOrderStatus the order status model.
     */
    private $orderStatus;

    /**
     * @var bool if special line items like shipping cost should be included.
     */
    private $includeSpecialLineItems = true;

    /**
     * @var string external order reference
     */
    private $externalOrderRef;

    /**
     * @inheritdoc
     */
    public function getValidationRules()
    {
        return array();
    }

    /**
     * Disables "special" line items when calling `loadData()`.
     * Special items are shipping cost, cart based discounts etc.
     */
    public function disableSpecialLineItems()
    {
        $this->includeSpecialLineItems = false;
    }

    /**
     * @inheritdoc
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Sets the ordernumber.
     *
     * The ordernumber must be a non-empty string.
     *
     * Usage:
     * $object->setOrderNumber('123456');
     *
     * @param string $orderNumber the ordernumber.
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @inheritdoc
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Sets the created date of the order.
     *
     * The created date must be a non-empty string in format Y-m-d.
     *
     * Usage:
     * $object->setCreatedDate('2016-01-20');
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
     * Sets the payment provider of the order.
     *
     * The payment provider must be a non-empty string.
     *
     * Usage:
     * $object->setPaymentProvider('invoice');
     *
     * @param string $paymentProvider the payment provider.
     */
    public function setPaymentProvider($paymentProvider)
    {
        $this->paymentProvider = $paymentProvider;
    }

    /**
     * @inheritdoc
     */
    public function getBuyerInfo()
    {
        return $this->buyerInfo;
    }

    /**
     * Sets the buyer information for the order.
     *
     * The buyer information must be an instance of NostoOrderBuyer.
     *
     * Usage:
     * $object->setBuyerInfo(new NostoOrderBuyer());
     *
     * @param NostoOrderBuyer $buyerInfo the buyer info.
     */
    public function setBuyerInfo($buyerInfo)
    {
        $this->buyerInfo = $buyerInfo;
    }

    /**
     * @inheritdoc
     */
    public function getPurchasedItems()
    {
        return $this->purchasedItems;
    }

    /**
     * Sets the purchased items for the order.
     *
     * The line items must be an array of NostoOrderLineItem
     *
     * Usage:
     * $object->setPurchasedItems([new NostoOrderLineItem(), ...]);
     *
     * @param NostoLineItemInterface[] $purchasedItems the purchased items.
     */
    public function setPurchasedItems($purchasedItems)
    {
        $this->purchasedItems = $purchasedItems;
    }

    /**
     * @inheritdoc
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * Sets the order status.
     *
     * The order status must be an instance of NostoOrderStatus.
     *
     * Usage:
     * $object->setOrderStatus(new NostoOrderStatus());
     *
     * @param NostoOrderStatus $orderStatus the buyer info.
     */
    public function setOrderStatus($orderStatus)
    {
        $this->orderStatus = $orderStatus;
    }

    /**
     * Add a purchased item for the order.
     *
     * The line item must be an array of NostoOrderLineItem
     *
     * Usage:
     * $object->addPurchasedItems(new NostoOrderLineItem());
     *
     * @param NostoLineItemInterface $purchasedItems
     */
    public function addPurchasedItems(NostoLineItemInterface $purchasedItems)
    {
        $this->purchasedItems[] = $purchasedItems;
    }

    /**
     * Sets the order status.
     *
     * The order status must be an instance of NostoOrderStatus.
     *
     * Usage:
     * $object->addOrderStatus(new NostoOrderStatus());
     *
     * @param NostoOrderStatus $orderStatus the buyer info.
     */
    public function addOrderStatus($orderStatus)
    {
        $this->orderStatus[] = $orderStatus;
    }

    /**
     * Returns the external order reference
     *
     * @return string
     */
    public function getExternalOrderRef()
    {
        return $this->externalOrderRef;
    }

    /**
     * Sets the external order reference
     *
     * @param string $externalOrderRef
     */
    public function setExternalOrderRef($externalOrderRef)
    {
        $this->externalOrderRef = $externalOrderRef;
    }
}
