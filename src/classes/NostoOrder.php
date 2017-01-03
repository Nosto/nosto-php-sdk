<?php
/**
 * Copyright (c) 2016, Nosto Solutions Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
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
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Nosto Solutions Ltd <shopware@nosto.com>
 * @copyright Copyright (c) 2016 Nosto Solutions Ltd (http://www.nosto.com)
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 */

/**
 * Model for order information. This is used when compiling the info about an
 * order that is sent to Nosto.
 *
 * Extends Shopware_Plugins_Frontend_NostoTagging_Components_Model_Base.
 * Implements NostoOrderInterface.
 * Implements NostoValidatableModelInterface.
 *
 * @package Shopware
 * @subpackage Plugins_Frontend
 */
class NostoOrder extends NostoObject implements NostoOrderInterface, NostoValidatableInterface
{
    /**
     * @var string|int the unique order number identifying the order.
     */
    private $_orderNumber;

    /**
     * @var string the date when the order was placed.
     */
    private $_createdDate;

    /**
     * @var string the payment provider used for order.
     *
     * Formatted according to "[provider name] [provider version]".
     */
    private $_paymentProvider;

    /**
     * @var NostoOrderBuyer The user info of the buyer.
     */
    private $_buyerInfo;

    /**
     * @var NostoLineItem[] the items in the order.
     */
    private $_purchasedItems = array();

    /**
     * @var NostoOrderStatus the order status model.
     */
    private $_orderStatus;

    /**
     * @var bool if special line items like shipping cost should be included.
     */
    private $_includeSpecialLineItems = true;

    /**
     * @var string external order reference
     */
    private $_externalOrderRef;

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
        $this->_includeSpecialLineItems = false;
    }

    /**
     * @inheritdoc
     */
    public function getOrderNumber()
    {
        return $this->_orderNumber;
    }

    /**
     * @inheritdoc
     */
    public function getCreatedDate()
    {
        return $this->_createdDate;
    }

    /**
     * @inheritdoc
     */
    public function getPaymentProvider()
    {
        return $this->_paymentProvider;
    }

    /**
     * @inheritdoc
     */
    public function getBuyerInfo()
    {
        return $this->_buyerInfo;
    }

    /**
     * @inheritdoc
     */
    public function getPurchasedItems()
    {
        return $this->_purchasedItems;
    }

    /**
     * @inheritdoc
     */
    public function getOrderStatus()
    {
        return $this->_orderStatus;
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
     *
     * @return $this Self for chaining
     */
    public function setOrderNumber($orderNumber)
    {
        $this->_orderNumber = $orderNumber;

        return $this;
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
     *
     * @return $this Self for chaining
     */
    public function setCreatedDate($createdDate)
    {
        $this->_createdDate = $createdDate;

        return $this;
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
     *
     * @return $this Self for chaining
     */
    public function setPaymentProvider($paymentProvider)
    {
        $this->_paymentProvider = $paymentProvider;

        return $this;
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
     *
     * @return $this Self for chaining
     */
    public function setBuyerInfo($buyerInfo)
    {
        $this->_buyerInfo = $buyerInfo;

        return $this;
    }

    /**
 * Sets the purchased items for the order.
 *
 * The line items must be an array of NostoOrderLineItem
 *
 * Usage:
 * $object->setPurchasedItems([new NostoOrderLineItem(), ...]);
 *
 * @param NostoOrderLineItem[] $purchasedItems the purchased items.
 *
 * @return $this Self for chaining
 */
    public function setPurchasedItems($purchasedItems)
    {
        $this->_purchasedItems = $purchasedItems;

        return $this;
    }

    /**
     * Add a purchased item for the order.
     *
     * The line item must be an array of NostoOrderLineItem
     *
     * Usage:
     * $object->addPurchasedItems(new NostoOrderLineItem());
     *
     * @param NostoOrderLineItem $purchasedItem the purchased item.
     *
     * @return $this Self for chaining
     */
    public function addPurchasedItems($purchasedItems)
    {
        $this->_purchasedItems[] = $purchasedItems;

        return $this;
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
     *
     * @return $this Self for chaining
     */
    public function setOrderStatus($orderStatus)
    {
        $this->_orderStatus = $orderStatus;

        return $this;
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
     *
     * @return $this Self for chaining
     */
    public function addOrderStatus($orderStatus)
    {
        $this->_orderStatus[] = $orderStatus;

        return $this;
    }

    /**
     * Returns the external order reference
     *
     * @return string
     */
    public function getExternalOrderRef()
    {
        return $this->_externalOrderRef;
    }

    /**
     * Sets the external order reference
     *
     * @param string $externalOrderRef
     */
    public function setExternalOrderRef($externalOrderRef)
    {
        $this->_externalOrderRef = $externalOrderRef;
    }
}
