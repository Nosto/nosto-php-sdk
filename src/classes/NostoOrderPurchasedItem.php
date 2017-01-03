<?php
/**
 * Copyright (c) 2016, Nosto Solutions Ltd
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
 * @copyright 2016 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

/**
 * Model for order line item information. This is used when compiling the info
 * about an order that is sent to Nosto.
 */
class NostoOrderPurchasedItem extends NostoObject implements NostoOrderPurchasedItemInterface
{
    /**
     * @var string the unique identifier of the purchased item.
     * If this item is for discounts or shipping cost, the id can be 0.
     */
    protected $_productId;

    /**
     * @var int the quantity of the item included in the order.
     */
    protected $_quantity;

    /**
     * @var string the name of the item included in the order.
     */
    protected $_name;

    /**
     * @var float The unit price of the item included in the order.
     */
    protected $_unitPrice;

    /**
     * @var string the 3-letter ISO code (ISO 4217) for the item currency.
     */
    protected $_currencyCode;

    /**
     * Loads a special item, e.g. shipping cost.
     *
     * @param string           $name the name of the item.
     * @param float|int|string $price the unit price of the item.
     * @param string           $currency the 3-letter ISO code (ISO 4217) for the item currency.
     */
    public function loadSpecialItemData($name, $price, $currency)
    {
        $this->_productId = -1;
        $this->_quantity = 1;
        $this->_name = $name;
        $this->_unitPrice = Nosto::helper('price')->format($price);
        $this->_currencyCode = strtoupper($currency);
    }

    /**
     * @inheritdoc
     */
    public function getProductId()
    {
        return $this->_productId;
    }

    /**
     * @inheritdoc
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @inheritdoc
     */
    public function getUnitPrice()
    {
        return $this->_unitPrice;
    }

    /**
     * @inheritdoc
     */
    public function getCurrencyCode()
    {
        return $this->_currencyCode;
    }

    /**
     * Sets the product ID for the given cart item.
     * The product ID must be an integer above zero.
     *
     * Usage:
     * $object->setProductId(1);
     *
     * @param int $id the product ID.
     *
     * @return $this Self for chaining
     */
    public function setProductId($id)
    {
        $this->_productId = $id;

        return $this;
    }

    /**
     * Sets the quantity for the given cart item.
     * The quantity must be an integer above zero.
     *
     * Usage:
     * $object->setQuantity(1);
     *
     * @param int $quantity the quantity.
     *
     * @return $this Self for chaining
     */
    public function setQuantity($quantity)
    {
        $this->_quantity = $quantity;

        return $this;
    }

    /**
     * Sets cart items name.
     *
     * The name must be a non-empty string.
     *
     * Usage:
     * $object->setName('My product');
     *
     * @param string $name the name.
     *
     * @return $this Self for chaining
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Sets the unit price of the cart item.
     *
     * The price must be a numeric value
     *
     * Usage:
     * $object->setPrice(99.99);
     *
     * @param double $unitPrice the price.
     *
     * @return $this Self for chaining
     */
    public function setPrice($unitPrice)
    {
        $this->_unitPrice = $unitPrice;

        return $this;
    }

    /**
     * Sets the currency code (ISO 4217) the cart item is sold in.
     *
     * The currency must be in ISO 4217 format
     *
     * Usage:
     * $object->setCurrency('USD');
     *
     * @param string $currency the currency code.
     *
     * @return $this Self for chaining
     */
    public function setCurrencyCode($currency)
    {
        $this->_currencyCode = $currency;

        return $this;
    }
}
