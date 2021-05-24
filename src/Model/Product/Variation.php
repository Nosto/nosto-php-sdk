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

namespace Nosto\Model\Product;

use Nosto\AbstractObject;
use Nosto\Mixins\HtmlEncoderTrait;
use Nosto\Types\HtmlEncodableInterface;
use Nosto\Types\MarkupableInterface;
use Nosto\Types\Product\ProductInterface;
use Nosto\Types\Product\VariationInterface;

/**
 * Model for variation information
 */
class Variation extends AbstractObject implements
    VariationInterface,
    MarkupableInterface,
    HtmlEncodableInterface
{
    use HtmlEncoderTrait;

    /**
     * The id of the variation
     *
     * @var mixed
     */
    private $variationId;

    /**
     * variation price
     *
     * @var float
     */
    private $price;

    /**
     * variation list price
     *
     * @var float
     */
    private $listPrice;

    /**
     * @var string the currency iso code.
     */
    private $priceCurrencyCode;

    /**
     * Availability of the variation
     * @see VariationInterface
     * @var string
     */
    private $availability;

    /**
     * @inheritdoc
     */
    public function getVariationId()
    {
        return $this->variationId;
    }

    /**
     * Setter for id
     *
     * @param mixed $variationId
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Setter for price
     *
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = round($price, 2);
    }

    /**
     * @inheritdoc
     */
    public function getListPrice()
    {
        return $this->listPrice;
    }

    /**
     * Setter for list price
     *
     * @param float $listPrice
     */
    public function setListPrice($listPrice)
    {
        $this->listPrice = round($listPrice, 2);
    }

    /**
     * @inheritdoc
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Setter for availability
     *
     * @param string $availability
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    /**
     * Sets the availability state of the variation
     *
     * The availability of the variation as either "InStock" or "OutOfStock"
     * depending upon the true or false value of the availability
     *
     * @param bool $available the availability.
     */
    public function setAvailable($available)
    {
        $this->availability = $available ?
            ProductInterface::IN_STOCK : ProductInterface::OUT_OF_STOCK;
    }

    /**
     * Sets the currency code (ISO 4217) the variation is sold in.
     *
     * The currency must be in ISO 4217 format
     *
     * Usage:
     * $object->setCurrency('USD');
     *
     * @param string $currency the currency code.
     */
    public function setPriceCurrencyCode($currency)
    {
        $this->priceCurrencyCode = $currency;
    }

    /**
     * @inheritdoc
     */
    public function getPriceCurrencyCode()
    {
        return $this->priceCurrencyCode;
    }

    public function getMarkupKey()
    {
        return 'variation';
    }
}
