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

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Helper\SerializationHelper;

class SerializationHelperTest extends Test
{
    use Specify;

    /**
     * Tests that a collection with objects is serialized correctly
     */
    public function testCollection()
    {
        $collection = new \Nosto\Object\Product\ProductCollection();
        $collection->append(new MockProduct());
        $this->assertEquals('[{"url":"http:\/\/my.shop.com\/products\/test_product.html","product_id":1,"name":"Test Product","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","price":99.99,"list_price":110.99,"price_currency_code":"USD","availability":"InStock","categories":["\/Mens","\/Mens\/Shoes"],"description":"This is a full description","brand":"Super Brand","variation_id":"USD","supplier_cost":22.33,"inventory_level":50,"review_count":99,"rating_value":2.5,"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"condition":"Used","gender":null,"age_group":null,"gtin":"gtin","tag1":["first"],"tag2":["second"],"tag3":["third"],"google_category":"All","unit_pricing_measure":null,"unit_pricing_base_measure":null,"unit_pricing_unit":null,"skus":[],"variations":[],"thumb_url":null,"custom_fields":[]}]', SerializationHelper::serialize($collection));
    }

    /**
     * Tests that an array with objects is serialized correctly
     */
    public function testObjectArray()
    {
        $array = [new MockProduct()];
        $this->assertEquals('[{"url":"http:\/\/my.shop.com\/products\/test_product.html","product_id":1,"name":"Test Product","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","price":99.99,"list_price":110.99,"price_currency_code":"USD","availability":"InStock","categories":["\/Mens","\/Mens\/Shoes"],"description":"This is a full description","brand":"Super Brand","variation_id":"USD","supplier_cost":22.33,"inventory_level":50,"review_count":99,"rating_value":2.5,"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"condition":"Used","gender":null,"age_group":null,"gtin":"gtin","tag1":["first"],"tag2":["second"],"tag3":["third"],"google_category":"All","unit_pricing_measure":null,"unit_pricing_base_measure":null,"unit_pricing_unit":null,"skus":[],"variations":[],"thumb_url":null,"custom_fields":[]}]', SerializationHelper::serialize($array));
    }

    /**
     * Tests that a simple array is serialized correctly
     */
    public function testSimpleArray()
    {
        $array = ['one', 1, 'two', 2];
        $this->assertEquals('["one",1,"two",2]', SerializationHelper::serialize($array));
    }
}
