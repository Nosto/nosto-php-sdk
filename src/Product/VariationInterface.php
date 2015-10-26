<?php
/**
 * Copyright (c) 2015, Nosto Solutions Ltd
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
 * @copyright 2015 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 */

/**
 * Interface for the meta data of a product variation.
 * This is used in product the tagging, when making product API requests and product history exports to Nosto.
 */
interface NostoProductVariationInterface
{
    /**
     * Returns the variation ID.
     *
     * @return string|int the variation ID.
     */
    public function getVariationId();

    /**
     * Returns the currency code (ISO 4217) for the variation.
     *
     * @return NostoCurrencyCode the price currency code.
     */
    public function getCurrency();

    /**
     * Returns the price of the variation including possible discounts and taxes.
     *
     * @return NostoPrice the price.
     */
    public function getPrice();

    /**
     * Returns the availability of the variation, i.e. if it is in stock or not.
     *
     * @return NostoProductAvailability the availability.
     */
    public function getAvailability();

    /**
     * Returns the absolute url to the product page of the variation in the shop frontend.
     * This value is optional.
     *
     * @return string|null the url or null if not used.
     */
    public function getUrl();

    /**
     * Returns the name of the product variation.
     * This value is optional.
     *
     * @return string|null the name or null if not used.
     */
    public function getName();

    /**
     * Returns the list price of the variation without discounts but incl taxes.
     * This value is optional.
     *
     * @return NostoPrice|null the price or null if not used.
     */
    public function getListPrice();

    /**
     * Returns the absolute url the one of the product variation images in the shop frontend.
     * This value is optional.
     *
     * @return string|null the url or null if not used.
     */
    public function getImageUrl();

    /**
     * Returns the absolute url to one of the product variation image thumbnails in the shop frontend.
     * This value is optional.
     *
     * @return string|null the url or null if not used.
     */
    public function getThumbUrl();

    /**
     * Returns the tags for the product variation.
     * This value is optional.
     *
     * @return array the tags array, e.g. array('tag1' => array("winter", "shoe")) or empty array if not used.
     */
    public function getTags();

    /**
     * Returns the categories the product variation is located in.
     * This value is optional.
     *
     * @return array list of category strings, e.g. array("/shoes/winter", "/shoes/boots") or empty array if not used.
     */
    public function getCategories();

    /**
     * Returns the product variation description.
     * This value is optional.
     *
     * @return string|null the description or null if not used.
     */
    public function getDescription();

    /**
     * Returns the product variation brand name.
     * This value is optional.
     *
     * @return string|null the brand name or null if not used.
     */
    public function getBrand();

    /**
     * Returns the product variation publication date in the shop.
     * This value is optional.
     *
     * @return NostoDate|null the date or null if not used.
     */
    public function getDatePublished();
}
