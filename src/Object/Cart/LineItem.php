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

namespace Nosto\Object\Cart;

use Nosto\AbstractObject;
use Nosto\Types\LineItemInterface;
use Nosto\Types\MarkupableInterface;

/**
 * Model class for containing a item in an OrderConfirm or a shopping cart. This is used as
 * the model when rendering the cart and OrderConfirm tagging and also for in OrderConfirm confirmation
 * API calls
 */
class LineItem extends AbstractObject implements LineItemInterface, MarkupableInterface
{
    /**
     * Product id for non saleable products such as shipping and discounts
     */
    const PSEUDO_PRODUCT_ID = '-1';

    /**
     * @var string the unique identifier of the purchased item.
     */
    private $productId;

    /**
     * @var int the quantity of the item included in the OrderConfirm.
     */
    private $quantity;

    /**
     * @var string the name of the item included in the OrderConfirm.
     */
    private $name;

    /**
     * @var double the unit price of the item included in the OrderConfirm.
     */
    private $unitPrice;

    /**
     * @var string the 3-letter ISO code (ISO 4217) for the item currency.
     */
    private $priceCurrencyCode;

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
        $this->setProductId(self::PSEUDO_PRODUCT_ID);
        $this->setQuantity(1);
        $this->setName($name);
        $this->setPrice($price);
        $this->setPriceCurrencyCode($currency);
    }

    /**
     * Sets the unit price of the cart item.
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
     * Sets the quantity of the cart item
     *
     * @param int $quantity the quantity
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
     * Sets the name of the cart item
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
    public function getPriceCurrencyCode()
    {
        return $this->priceCurrencyCode;
    }

    /**
     * Sets the currency code of the cart item
     *
     * @param string $priceCurrencyCode the currency code.
     */
    public function setPriceCurrencyCode($priceCurrencyCode)
    {
        $this->priceCurrencyCode = strtoupper($priceCurrencyCode);
    }

    public function getMarkupKey()
    {
        return "line_item";
    }
}
