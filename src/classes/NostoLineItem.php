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
 * Model for order line item information. This is used when compiling the info
 * about an order that is sent to Nosto.
 */
class NostoLineItem extends NostoObject implements NostoLineItemInterface
{
    const PSEUDO_PRODUCT_ID = '-1';
    /**
     * @var string the unique identifier of the purchased item.
     * If this item is for discounts or shipping cost, the id can be 0.
     */
    private $productId;

    /**
     * @var int the quantity of the item included in the order.
     */
    private $quantity;

    /**
     * @var string the name of the item included in the order.
     */
    private $name;

    /**
     * @var double The unit price of the item included in the order.
     */
    private $unitPrice;

    /**
     * @var string the 3-letter ISO code (ISO 4217) for the item currency.
     */
    private $currencyCode;

    public function __construct()
    {
        // Dummy
    }

    /**
     * Loads a special item, e.g. shipping cost.
     *
     * @param string $name the name of the item.
     * @param float|int|double $price the unit price of the item.
     * @param string $currency the 3-letter ISO code (ISO 4217) for the item currency.
     */
    public function loadSpecialItemData($name, $price, $currency)
    {
        $this->productId = self::PSEUDO_PRODUCT_ID;
        $this->quantity = 1;
        $this->name = $name;
        $this->unitPrice = $price;
        $this->currencyCode = strtoupper($currency);
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
     */
    public function setPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @inheritdoc
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Sets the product ID for the given cart item.
     *
     * @param string $id the product ID.
     */
    public function setProductId($id)
    {
        $this->productId = $id;
    }

    /**
     * @inheritdoc
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets the quantity for the given cart item.
     * The quantity must be an integer above zero.
     *
     * Usage:
     * $object->setQuantity(1);
     *
     * @param int $quantity the quantity.
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
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
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @inheritdoc
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
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
     */
    public function setCurrencyCode($currency)
    {
        $this->currencyCode = $currency;
    }
}
