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

namespace Nosto\Model\Product;

use Nosto\AbstractObject;
use Nosto\Mixins\HtmlEncoderTrait;
use Nosto\Types\HtmlEncodableInterface;
use Nosto\Types\MarkupableInterface;
use Nosto\Types\Product\SkuInterface;
use Nosto\Types\Product\ProductInterface;

/**
 * Model for sku information
 */
class Sku extends AbstractObject implements
    SkuInterface,
    MarkupableInterface,
    HtmlEncodableInterface
{
    use HtmlEncoderTrait;

    /**
     * The id of the SKU
     *
     * @var mixed
     */
    private $id;

    /**
     * The name of the SKU
     *
     * @var string
     */
    private $name;

    /**
     * SKU price
     *
     * @var float
     */
    private $price;

    /**
     * SKU list price
     *
     * @var float
     */
    private $listPrice;

    /**
     * URL of the SKU
     *
     * @var string
     */
    private $url;

    /**
     * Image URL of the SKU
     *
     * @var string
     */
    private $imageUrl;

    /**
     * Gtin of the SKU
     *
     * @var string
     */
    private $gtin;

    /**
     * Availability of the SKU
     * @see ProductInterface
     * @var string
     */
    private $availability;

    /**
     * An array of custom attributes
     * @var array
     */
    private $customFields = [];

    /**
     * @var int|null product stock level
     */
    private $inventoryLevel;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter for id
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter for name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
        $this->price = $price;
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
        $this->listPrice = $listPrice;
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Setter for URL
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @inheritdoc
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Setter for image url
     *
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @inheritdoc
     */
    public function getGtin()
    {
        return $this->gtin;
    }

    /**
     * Setter for gtin
     *
     * @param string $gtin
     */
    public function setGtin($gtin)
    {
        $this->gtin = $gtin;
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
     * @inheritdoc
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * Setter for custom attributes
     *
     * @param array $customFields
     */
    public function setCustomFields(array $customFields)
    {
        $this->customFields = $customFields;
    }

    /**
     * Add a custom attribute
     *
     * @param $attribute
     * @param $value
     */
    public function addCustomField($attribute, $value)
    {
        if ($this->customFields === null) {
            $this->customFields = [];
        }
        $this->customFields[$attribute] = $value;
    }

    /**
     * Sets the availability state of the SKU
     *
     * The availability of the sku as either "InStock" or "OutOfStock"
     * depending upon the true or false value of the availability
     *
     * @param bool $available the availability.
     */
    public function setAvailable($available)
    {
        $this->availability = $available ?
            ProductInterface::IN_STOCK : ProductInterface::OUT_OF_STOCK;
    }

    public function getMarkupKey()
    {
        return 'nosto_sku';
    }

    /**
     * Returns the inventory stock level
     *
     * @return int|null
     */
    public function getInventoryLevel()
    {
        return $this->inventoryLevel;
    }

    /**
     * @param int|null $inventoryLevel
     */
    public function setInventoryLevel($inventoryLevel)
    {
        $this->inventoryLevel = $inventoryLevel;
    }

    /**
     * @inheritdoc
     */
    public function sanitize()
    {
        $sanitized = clone $this;
        $sanitized->setInventoryLevel(null);

        return $sanitized;
    }
}
