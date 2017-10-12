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

namespace Nosto\Types\Product;

/**
 * Interface for the meta data of a product.
 * This is used when making product re-crawl API requests and product history exports to Nosto.
 */
interface ProductInterface
{
    const IN_STOCK = 'InStock';
    const OUT_OF_STOCK = 'OutOfStock';
    const INVISIBLE = 'Invisible';
    const DISCONTINUED = 'Discontinued';
    const ADD_TO_CART = 'add-to-cart';
    const LOW_STOCK = 'low-stock';

    /**
     * Returns the absolute url to the product page in the shop frontend.
     *
     * @return string the url.
     */
    public function getUrl();

    /**
     * Returns the product's unique identifier.
     *
     * @return int|string the ID.
     */
    public function getProductId();

    /**
     * Returns the name of the product.
     *
     * @return string the name.
     */
    public function getName();

    /**
     * Returns the absolute url the one of the product images in the shop frontend.
     *
     * @return string the url.
     */
    public function getImageUrl();

    /**
     * Returns the price of the product including possible discounts and taxes.
     *
     * @return int|float the price with 2 decimals, e.g. 1000.99.
     */
    public function getPrice();

    /**
     * Returns the list price of the product without discounts but including possible taxes.
     *
     * @return int|float the price with 2 decimals, e.g. 1000.99.
     */
    public function getListPrice();

    /**
     * Returns the currency code (ISO 4217) the product is sold in.
     *
     * @return string the currency ISO code.
     */
    public function getPriceCurrencyCode();

    /**
     * Returns the availability of the product, i.e. if it is in stock or not.
     *
     * @return string the availability, either "InStock" or "OutOfStock".
     */
    public function getAvailability();

    /**
     * Returns the first set of tags for the product.
     *
     * @return array|null first set of the tags
     */
    public function getTag1();

    /**
     * Returns the second set of tags for the product.
     *
     * @return array|null second set of the tags
     */
    public function getTag2();

    /**
     * Returns the third set of tags for the product.
     *
     * @return array|null third set of the tags
     */
    public function getTag3();

    /**
     * Returns the categories the product is located in.
     *
     * @return array|null list of category strings.
     */
    public function getCategories();

    /**
     * Returns the product description.
     *
     * @return string the description.
     */
    public function getDescription();

    /**
     * Returns the product brand name.
     *
     * @return string the brand name.
     */
    public function getBrand();

    /**
     * Returns the product variation id.
     *
     * @return mixed|null
     */
    public function getVariationId();

    /**
     * Returns the supplier cost
     *
     * @return float|null
     */
    public function getSupplierCost();

    /**
     * Returns the inventory level
     *
     * @return int|null
     */
    public function getInventoryLevel();

    /**
     * Returns the count of reviews
     *
     * @return int|null
     */
    public function getReviewCount();

    /**
     * Returns the value of the rating(s)
     *
     * @return float|null
     */
    public function getRatingValue();

    /**
     * Returns the alternative images
     *
     * @return array|null
     */
    public function getAlternateImageUrls();

    /**
     * Returns the condition
     *
     * @return string|null
     */
    public function getCondition();

    /**
     * Returns the gender
     *
     * @return string|null
     */
    public function getGender();

    /**
     * Returns the age group
     *
     * @return string|null
     */
    public function getAgeGroup();

    /**
     * Returns the GTIN / barcode
     *
     * @return string|null
     */
    public function getGtin();

    /**
     * Returns the category used for Google's services
     *
     * @return string|null
     */
    public function getGoogleCategory();

    /**
     * Returns the pricing measure of the product. Pricing measure for a 0.33
     * liter bottle for example is "0.33".
     *
     * @return float|null
     */
    public function getUnitPricingMeasure();

    /**
     * Returns the pricing base measure of the product. Pricing base measure
     * for a 0.33l bottle is "1".
     *
     * @return float|null
     */
    public function getUnitPricingBaseMeasure();

    /**
     * Returns the pricing unit of the product. Pricing unit for a 0.33l
     * bottle is "l" (litre).
     *
     * @return string|null
     */
    public function getUnitPricingUnit();

    /**
     * Returns the product variations
     *
     * @return \Nosto\Object\Product\SkuCollection
     */
    public function getSkus();

    /**
     * Returns the thumbnail URL for product image
     *
     * @return string
     */
    public function getThumbUrl();

    /**
     * Returns the product variations if any exist.
     *
     * @return VariationInterface[] the variations.
     */
    public function getVariations();
}
