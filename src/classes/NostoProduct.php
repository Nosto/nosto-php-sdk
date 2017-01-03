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
 * Model for product information. This is used when compiling the info about a
 * product that is sent to Nosto.
 */
class NostoProduct extends NostoObject implements NostoProductInterface, NostoValidatableInterface
{
    /**
     * @var string absolute url to the product page.
     */
    private $url; //@codingStandardsIgnoreLine

    /**
     * @var string product object id.
     */
    private $productId; //@codingStandardsIgnoreLine

    /**
     * @var string product name.
     */
    private $name; //@codingStandardsIgnoreLine

    /**
     * @var string absolute url to the product image.
     */
    private $imageUrl; //@codingStandardsIgnoreLine

    /**
     * @var string product price, discounted including vat.
     */
    private $price; //@codingStandardsIgnoreLine

    /**
     * @var string product list price, including vat.
     */
    private $listPrice; //@codingStandardsIgnoreLine

    /**
     * @var string the currency iso code.
     */
    private $currencyCode; //@codingStandardsIgnoreLine

    /**
     * @var string product availability (use constants).
     */
    private $availability; //@codingStandardsIgnoreLine

    /**
     * @var array list of product tags.
     */
    private $tags = array( //@codingStandardsIgnoreLine
        'tag1' => array(),
        'tag2' => array(),
        'tag3' => array(),
    );

    /**
     * @var array list of product category strings.
     */
    private $categories = array(); //@codingStandardsIgnoreLine

    /**
     * @var string the product short description.
     */
    private $shortDescription; //@codingStandardsIgnoreLine

    /**
     * @var string the product description.
     */
    private $description; //@codingStandardsIgnoreLine

    /**
     * @var string the product brand name.
     */
    private $brand; //@codingStandardsIgnoreLine

    /**
     * @var string the default variation identifier of the shop
     */
    private $_variationId;

    /**
     * @var float the price paid for the supplier
     */
    private $_supplierCost;

    /**
     * @var int product stock
     */
    private $_inventoryLevel;

    /**
     * @var int the amount of reviews
     */
    private $_reviewCount;

    /**
     * @var float the value of the rating(s)
     */
    private $_ratingValue;

    /**
     * @var array alternative image urls
     */
    private $_alternateImageUrls;

    /**
     * @var string the condition of the product
     */
    private $_condition;

    /**
     * @var string the gender (target group) of the product
     */
    private $_gender;

    /**
     * @var string the the age group
     */
    private $_ageGroup;

    /**
     * @var string the barcode
     */
    private $_gtin;

    /**
     * @var string category used in Google's services
     */
    private $_googleCategory;

    /**
     * @var string the pricing measure of the product. Pricing measure for a
     * 0.33 liter bottle for example is "0.33".
     */
    private $_unitPricingMeasure;

    /**
     * @var string the pricing base measure of the product. Pricing base measure
     * for a 0.33l bottle is "1".
     */
    private $_unitPricingBaseMeasure;

    /**
     * @var string the pricing unit of the product. Pricing unit for a 0.33l
     * bottle is "l" (litre).
     */
    private $_unitPricingUnit;

    /**
     * @inheritdoc
     */
    public function getValidationRules()
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @inheritdoc
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @inheritdoc
     */
    public function getListPrice()
    {
        return $this->listPrice;
    }

    /**
     * @inheritdoc
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @inheritdoc
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @inheritdoc
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @inheritdoc
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @inheritdoc
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     */
    public function getFullDescription()
    {
        $descriptions = array();
        if (!empty($this->shortDescription)) {
            $descriptions[] = $this->shortDescription;
        }
        if (!empty($this->description)) {
            $descriptions[] = $this->description;
        }
        return implode(' ', $descriptions);
    }

    /**
     * @inheritdoc
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Sets the product ID from given product.
     *
     * The product ID must be an integer above zero.
     *
     * Usage:
     * $object->setProductId(1);
     *
     * @param int $id the product ID.
     */
    public function setProductId($id)
    {
        $this->productId = $id;
    }

    /**
     * Sets the availability state of the product.
     *
     * The availability of the product must be either "InStock" or "OutOfStock"
     *
     * Usage:
     * $object->setAvailability('InStock');
     *
     * @param string $availability the availability.
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    /**
     * Sets the availability state of the product.
     *
     * The availability of the product as either "InStock" or "OutOfStock"
     * depending upon the true or false value of the availability
     *
     * Usage:
     * $object->setAvailable(true);
     *
     * @param bool $available the availability.
     */
    public function setAvailable($available)
    {
        $this->availability = $available ?
            NostoProductInterface::IN_STOCK : NostoProductInterface::OUT_OF_STOCK;
    }

    /**
     * Sets the currency code (ISO 4217) the product is sold in.
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

    /**
     * Sets the product price.
     *
     * The price must be a numeric value
     *
     * Usage:
     * $object->setPrice(99.99);
     *
     * @param integer $price the price.
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Sets the product list price.
     *
     ** The price must be a numeric value
     *
     * Usage:
     * $object->setListPrice(99.99);
     *
     * @param integer $listPrice the price.
     */
    public function setListPrice($listPrice)
    {
        $this->listPrice = $listPrice;
    }

    /**
     * Sets all the tags to the `tag1` field.
     *
     * The tags must be an array of non-empty string values.
     *
     * Usage:
     * $object->setTag1(array('customTag1', 'customTag2'));
     *
     * @param array $tags the tags.
     */
    public function setTag1(array $tags)
    {
        $this->tags['tag1'] = array();
        foreach ($tags as $tag) {
            $this->addTag1($tag);
        }
    }

    /**
     * Adds a new tag to the `tag1` field.
     *
     * The tag must be a non-empty string value.
     *
     * Usage:
     * $object->addTag1('customTag');
     *
     * @param string $tag the tag to add.
     */
    public function addTag1($tag)
    {
        $this->tags['tag1'][] = $tag;
    }

    /**
     * Sets all the tags to the `tag2` field.
     *
     * The tags must be an array of non-empty string values.
     *
     * Usage:
     * $object->setTag2(array('customTag1', 'customTag2'));
     *
     * @param array $tags the tags.
     */
    public function setTag2(array $tags)
    {
        $this->tags['tag2'] = array();
        foreach ($tags as $tag) {
            $this->addTag2($tag);
        }
    }

    /**
     * Adds a new tag to the `tag2` field.
     *
     * The tag must be a non-empty string value.
     *
     * Usage:
     * $object->addTag2('customTag');
     *
     * @param string $tag the tag to add.
     */
    public function addTag2($tag)
    {
        $this->tags['tag2'][] = $tag;
    }

    /**
     * Sets all the tags to the `tag3` field.
     *
     * The tags must be an array of non-empty string values.
     *
     * Usage:
     * $object->setTag3(array('customTag1', 'customTag2'));
     *
     * @param array $tags the tags.
     */
    public function setTag3(array $tags)
    {
        $this->tags['tag3'] = array();
        foreach ($tags as $tag) {
            $this->addTag3($tag);
        }
    }

    /**
     * Adds a new tag to the `tag3` field.
     *
     * The tag must be a non-empty string value.
     *
     * Usage:
     * $object->addTag3('customTag');
     *
     * @param string $tag the tag to add.
     */
    public function addTag3($tag)
    {
        $this->tags['tag3'][] = $tag;
    }

    /**
     * Sets the brand name of the product manufacturer.
     *
     * The name must be a non-empty string.
     *
     * Usage:
     * $object->setBrand('Example');
     *
     * @param string $brand the brand name.
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * Sets the product categories.
     *
     * The categories must be an array of non-empty string values. The
     * categories are expected to include the entire sub/parent category path,
     * e.g. "clothes/winter/coats".
     *
     * Usage:
     * $object->setCategories(array('clothes/winter/coats' [, ... ] ));
     *
     * @param array $categories the categories.
     */
    public function setCategories(array $categories)
    {
        $this->categories = array();
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    /**
     * Adds a category to the product.
     *
     * The category must be a non-empty string and is expected to include the
     * entire sub/parent category path, e.g. "clothes/winter/coats".
     *
     * Usage:
     * $object->addCategory('clothes/winter/coats');
     *
     * @param string $category the category.
     */
    public function addCategory($category)
    {
        $this->categories[] = $category;
    }

    /**
     * Sets the product name.
     *
     * The name must be a non-empty string.
     *
     * Usage:
     * $object->setName('Example');
     *
     * @param string $name the name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Sets the URL for the product page in the shop that shows this product.
     *
     * The URL must be absolute, i.e. must include the protocol http or https.
     *
     * Usage:
     * $object->setUrl("http://my.shop.com/products/example.html");
     *
     * @param string $url the url.
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Sets the image URL for the product.
     *
     * The URL must be absolute, i.e. must include the protocol http or https.
     *
     * Usage:
     * $object->setImageUrl("http://my.shop.com/media/example.jpg");
     *
     * @param string $imageUrl the url.
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * Sets the product description.
     *
     * The description must be a non-empty string.
     *
     * Usage:
     * $object->setDescription('Lorem ipsum dolor sit amet, ludus possim ut ius, bonorum ea. ... ');
     *
     * @param string $description the description.
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Sets the product `short` description.
     *
     * The description must be a non-empty string.
     *
     * Usage:
     * $object->setShortDescription('Lorem ipsum dolor sit amet, ludus possim ut ius.');
     *
     * @param string $shortDescription the `short` description.
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
    }

    /**
     * @inheritdoc
     */
    public function getVariationId()
    {
        return $this->_variationId;
    }

    /**
     * @inheritdoc
     */
    public function getSupplierCost()
    {
        return $this->_supplierCost;
    }

    /**
     * @inheritdoc
     */
    public function getInventoryLevel()
    {
        return $this->_inventoryLevel;
    }

    /**
     * @inheritdoc
     */
    public function getReviewCount()
    {
        return $this->_reviewCount;
    }

    /**
     * @inheritdoc
     */
    public function getRatingValue()
    {
        return $this->_ratingValue;
    }

    /**
     * @inheritdoc
     */
    public function getAlternateImageUrls()
    {
        return $this->_alternateImageUrls;
    }

    /**
     * @inheritdoc
     */
    public function getCondition()
    {
        return $this->_condition;
    }

    /**
     * @inheritdoc
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @inheritdoc
     */
    public function getAgeGroup()
    {
        return $this->_ageGroup;
    }

    /**
     * @inheritdoc
     */
    public function getGtin()
    {
        return $this->_gtin;
    }

    /**
     * @inheritdoc
     */
    public function getGoogleCategory()
    {
        return $this->_googleCategory;
    }

    /**
     * @inheritdoc
     */
    public function getUnitPricingMeasure()
    {
        return $this->_unitPricingMeasure;
    }

    /**
     * @inheritdoc
     */
    public function getUnitPricingBaseMeasure()
    {
        return $this->_unitPricingBaseMeasure;
    }

    /**
     * @inheritdoc
     */
    public function getUnitPricingUnit()
    {
        return $this->_unitPricingUnit;
    }
}
