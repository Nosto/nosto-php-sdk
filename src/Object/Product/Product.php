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

namespace Nosto\Object\Product;

use Nosto\AbstractObject;
use Nosto\Types\Markupable;
use Nosto\Types\Product\ProductInterface;
use Nosto\Types\Product\SkuInterface;
use Nosto\Types\Product\VariationInterface;
use Nosto\Types\ValidatableInterface;

/**
 * Model for product information. This is used when compiling the info about a
 * product that is sent to Nosto.
 *
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 * @SuppressWarnings(PHPMD.NPathComplexity)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class Product extends AbstractObject implements ProductInterface, ValidatableInterface, Markupable
{
    /**
     * @var string absolute url to the product page.
     */
    private $url;

    /**
     * @var string product object id.
     */
    private $productId;

    /**
     * @var string product name.
     */
    private $name;

    /**
     * @var string absolute url to the product image.
     */
    private $imageUrl;

    /**
     * @var int|float product price, discounted including vat.
     */
    private $price;

    /**
     * @var int|float product list price, including vat.
     */
    private $listPrice;

    /**
     * @var string the currency iso code.
     */
    private $priceCurrencyCode;

    /**
     * @var string product availability (use constants).
     */
    private $availability;

    /**
     * @var array list of product category strings.
     */
    private $categories = array();

    /**
     * @var string the product description.
     */
    private $description;

    /**
     * @var string the product brand name.
     */
    private $brand;

    /**
     * @var string the default variation identifier of the shop
     */
    private $variationId;

    /**
     * @var float the price paid for the supplier
     */
    private $supplierCost;

    /**
     * @var int product stock
     */
    private $inventoryLevel;

    /**
     * @var int the amount of reviews
     */
    private $reviewCount;

    /**
     * @var float the value of the rating(s)
     */
    private $ratingValue;

    /**
     * @var array alternative image urls
     */
    private $alternateImageUrls = array();

    /**
     * @var string the condition of the product
     */
    private $condition;

    /**
     * @var string the gender (target group) of the product
     */
    private $gender;

    /**
     * @var string the the age group
     */
    private $ageGroup;

    /**
     * @var string the barcode
     */
    private $gtin;

    /**
     * @var array the first set of tags of the product
     */
    private $tag1 = array();

    /**
     * @var array the second set of tags of the product
     */
    private $tag2 = array();

    /**
     * @var array the third set of tags of the product
     */
    private $tag3 = array();

    /**
     * @var string category used in Google's services
     */
    private $googleCategory;

    /**
     * @var string the pricing measure of the product. Pricing measure for a
     * 0.33 liter bottle for example is "0.33".
     */
    private $unitPricingMeasure;

    /**
     * @var string the pricing base measure of the product. Pricing base measure
     * for a 0.33l bottle is "1".
     */
    private $unitPricingBaseMeasure;

    /**
     * @var string the pricing unit of the product. Pricing unit for a 0.33l
     * bottle is "l" (litre).
     */
    private $unitPricingUnit;

    /**
     * SKUs
     *
     * @var SkuCollection of SKUs
     */
    private $skus;

    /**
     * SKUs
     *
     * @var \Nosto\Object\Product\VariationCollection of variations
     */
    private $variations;

    /**
     * @var string url to the product thumbnail image
     */
    private $thumbUrl;

    public function __construct()
    {
        $this->skus = new SkuCollection();
        $this->variations = new VariationCollection();
    }

    /**
     * @inheritdoc
     */
    public function validationRules()
    {
        return array();
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the product description.
     *
     * @param string $description the description.
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
            ProductInterface::IN_STOCK : ProductInterface::OUT_OF_STOCK;
    }

    /**
     * @inheritdoc
     */
    public function getTag1()
    {
        return $this->tag1;
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
        $this->tag1[] = $tag;
    }

    /**
     * @inheritdoc
     */
    public function getTag2()
    {
        return $this->tag2;
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
        $this->tag2[] = $tag;
    }

    /**
     * @inheritdoc
     */
    public function getTag3()
    {
        return $this->tag3;
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
        $this->tag3[] = $tag;
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->url;
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
     * @inheritdoc
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Sets the product ID from given product.
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the product name.
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
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Sets the image URL for the product.
     *
     * @param string $imageUrl the url.
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Sets the product price.
     *
     * @param int|float $price the price.
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @inheritdoc
     */
    public function getPriceCurrencyCode()
    {
        return $this->priceCurrencyCode;
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
    public function setPriceCurrencyCode($currency)
    {
        $this->priceCurrencyCode = $currency;
    }

    /**
     * @inheritdoc
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Sets the availability state of the product.
     *
     * @param string $availability the availability.
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    /**
     * @inheritdoc
     */
    public function getCategories()
    {
        return $this->categories;
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
     * @inheritdoc
     */
    public function getListPrice()
    {
        return $this->listPrice;
    }

    /**
     * Sets the product list price.
     *
     * @param int|float $listPrice the price.
     */
    public function setListPrice($listPrice)
    {
        $this->listPrice = $listPrice;
    }

    /**
     * @inheritdoc
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Sets the brand name of the product manufacturer.
     *
     * @param string $brand the brand name.
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }

    /**
     * @inheritdoc
     */
    public function getVariationId()
    {
        return $this->variationId;
    }

    /**
     * @param string $variationId
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;
    }

    /**
     * @inheritdoc
     */
    public function getSupplierCost()
    {
        return $this->supplierCost;
    }

    /**
     * @param float $supplierCost
     */
    public function setSupplierCost($supplierCost)
    {
        $this->supplierCost = $supplierCost;
    }

    /**
     * @inheritdoc
     */
    public function getInventoryLevel()
    {
        return $this->inventoryLevel;
    }

    /**
     * @param int $inventoryLevel
     */
    public function setInventoryLevel($inventoryLevel)
    {
        $this->inventoryLevel = $inventoryLevel;
    }

    /**
     * @inheritdoc
     */
    public function getReviewCount()
    {
        return $this->reviewCount;
    }

    /**
     * @param int $reviewCount
     */
    public function setReviewCount($reviewCount)
    {
        $this->reviewCount = $reviewCount;
    }

    /**
     * @inheritdoc
     */
    public function getRatingValue()
    {
        return $this->ratingValue;
    }

    /**
     * @param float $ratingValue
     */
    public function setRatingValue($ratingValue)
    {
        $this->ratingValue = $ratingValue;
    }

    /**
     * @inheritdoc
     */
    public function getAlternateImageUrls()
    {
        return array_values(array_diff($this->alternateImageUrls, array($this->getImageUrl())));
    }

    /**
     * @param array $alternateImageUrls
     */
    public function setAlternateImageUrls(array $alternateImageUrls)
    {
        $this->alternateImageUrls = $alternateImageUrls;
    }

    /**
     * @param string $alternateImageUrl
     */
    public function addAlternateImageUrls($alternateImageUrl)
    {
        $this->alternateImageUrls[] = $alternateImageUrl;
    }

    /**
     * @inheritdoc
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @inheritdoc
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @inheritdoc
     */
    public function getAgeGroup()
    {
        return $this->ageGroup;
    }

    /**
     * @param string $ageGroup
     */
    public function setAgeGroup($ageGroup)
    {
        $this->ageGroup = $ageGroup;
    }

    /**
     * @inheritdoc
     */
    public function getGtin()
    {
        return $this->gtin;
    }

    /**
     * @param string $gtin
     */
    public function setGtin($gtin)
    {
        $this->gtin = $gtin;
    }

    /**
     * @inheritdoc
     */
    public function getGoogleCategory()
    {
        return $this->googleCategory;
    }

    /**
     * @param string $googleCategory
     */
    public function setGoogleCategory($googleCategory)
    {
        $this->googleCategory = $googleCategory;
    }

    /**
     * @inheritdoc
     */
    public function getUnitPricingMeasure()
    {
        return $this->unitPricingMeasure;
    }

    /**
     * @param string $unitPricingMeasure
     */
    public function setUnitPricingMeasure($unitPricingMeasure)
    {
        $this->unitPricingMeasure = $unitPricingMeasure;
    }

    /**
     * @inheritdoc
     */
    public function getUnitPricingBaseMeasure()
    {
        return $this->unitPricingBaseMeasure;
    }

    /**
     * @param string $unitPricingBaseMeasure
     */
    public function setUnitPricingBaseMeasure($unitPricingBaseMeasure)
    {
        $this->unitPricingBaseMeasure = $unitPricingBaseMeasure;
    }

    /**
     * @inheritdoc
     */
    public function getUnitPricingUnit()
    {
        return $this->unitPricingUnit;
    }

    /**
     * @param string $unitPricingUnit
     */
    public function setUnitPricingUnit($unitPricingUnit)
    {
        $this->unitPricingUnit = $unitPricingUnit;
    }

    /**
     * @inheritdoc
     */
    public function getSkus()
    {
        return $this->skus;
    }

    /**
     * Sets the SKUs
     *
     * @param SkuCollection $skus
     */
    public function setSkus(SkuCollection $skus)
    {
        $this->skus = $skus;
    }

    /**
     * Sets the SKUs
     *
     * @param SkuInterface $sku
     */
    public function addSku(SkuInterface $sku)
    {
        $this->skus->append($sku);
    }

    /**
     * @inheritdoc
     */
    public function getThumbUrl()
    {
        return $this->thumbUrl;
    }

    /**
     * Sets the thumb URL
     *
     * @param string $thumbUrl
     */
    public function setThumbUrl($thumbUrl)
    {
        $this->thumbUrl = $thumbUrl;
    }

    /**
     * @inheritdoc
     */
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * Sets the variations
     *
     * @param VariationCollection $variations
     */
    public function setVariations(VariationCollection $variations)
    {
        $this->variations = $variations;
    }

    /**
     * Sets the variations
     *
     * @param VariationInterface $variation
     */
    public function addVariation(VariationInterface $variation)
    {
        $this->variations->append($variation);
    }

    function getMarkupKey()
    {
        return 'nosto_product';
    }

    function getMarkupKeyForArrayPropertyItem($propertyName)
    {
        if (!$propertyName) {
            return null;
        }
        $propertyName = strtolower($propertyName);

        if ($propertyName === 'categories') {
            return "category";
        } else if ($propertyName === 'alternateimageurls') {
            return 'alternate_image_url';
        } else if ($propertyName === 'tag1' || $propertyName === 'tag2'|| $propertyName === 'tag3') {
            return 'tag';
        }

        return null;
    }
}
