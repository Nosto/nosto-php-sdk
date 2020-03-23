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

namespace Nosto\Test\Unit\Helper;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Helper\SerializationHelper;
use Nosto\Test\Support\MockProduct;
use Nosto\Test\Support\MockProductWithSku;
use Nosto\Test\Support\MockSku;
use Nosto\Model\Product\ProductCollection;

class SerializationHelperTest extends Test
{
    use Specify;

    /**
     * Tests that an object is serialized correctly
     */
    public function testObjectWithAltImages()
    {
        $object = new MockProduct();
        $mainImage = 'http://my.shop.com/images/test_product_image.jpg';
        $altImages = [
            $mainImage,
            'http://shop.com/product_alt.jpg',
            'http://shop.com/product_alt.jpg',
            'http://shop.com/product_alt_1.jpg',
        ];
        $object->setAlternateImageUrls($altImages);
        $object->setImageUrl($mainImage);

        $serialized = SerializationHelper::serialize($object);
        $this->assertEquals('{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg","http:\/\/shop.com\/product_alt_1.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product_image.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}', $serialized);
    }

    /**
     * Tests that an object is serialized correctly
     */
    public function testObject()
    {
        $object = new MockProduct();
        $serialized = SerializationHelper::serialize($object);
        $this->assertEquals('{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}', $serialized);
    }

    /**
     * Tests that a customer object containing inline html is serialized correctly
     */
    public function testObjectWithHtmlTags()
    {
        $object = new MockProduct();
        $object->addCustomField('customFieldOne', '<div class="customClassOne">Custom field one</div>');
        $object->addCustomField('customFieldTwo', "<div class='customClassTwo'>Custom field two</div>");
        $serializedObject = SerializationHelper::serialize($object);
        $this->assertEquals('{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","custom_fields":{"customFieldOne":"<div class=\"customClassOne\">Custom field one<\/div>","customFieldTwo":"<div class=\'customClassTwo\'>Custom field two<\/div>"},"date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}', $serializedObject);
    }

    /**
     * Tests that a collection with objects is serialized correctly
     */
    public function testObjectCollection()
    {
        $collection = new ProductCollection();
        $collection->append(new MockProduct());
        $serialized = SerializationHelper::serialize($collection);
        $this->assertEquals('[{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}]', $serialized);
    }

    /**
     * Tests that an array with objects is serialized correctly
     */
    public function testObjectArray()
    {
        $array = [new MockProduct()];
        $serialized = SerializationHelper::serialize($array);
        $this->assertEquals('[{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}]', $serialized);
    }

    /**
     * Tests that a simple array is serialized correctly
     */
    public function testSimpleArray()
    {
        $array = ['one', 1, 'two', 2];
        $this->assertEquals('["one",1,"two",2]', SerializationHelper::serialize($array));
    }

    /**
     * Tests that custom fields are not converted to snake case
     */
    public function testObjectWithCustomFields()
    {
        $object = new MockProduct();
        $object->addCustomField('shouldNotBeSnakeCase', 'value');
        $serialized = SerializationHelper::serialize($object);
        $this->assertEquals('{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","custom_fields":{"shouldNotBeSnakeCase":"value"},"date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}', $serialized);
    }

    /**
     * Tests that custom fields with scandic characters are preserved
     */
    public function testObjectWithScandicCustomFields()
    {
        $object = new MockProduct();
        $object->addCustomField('spesialCäåös', 'value');
        $serialized = SerializationHelper::serialize($object);
        $this->assertEquals('{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","custom_fields":{"spesialC\u00e4\u00e5\u00f6s":"value"},"date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}', $serialized);
    }

    /**
     * Tests that an object with key that contains special characters is serialized correctly
     */
    public function testObjectWithSpecialCharacters()
    {
        $object = new MockProduct();
        $object->addCustomField('key.with.\special?char s*', 'åäöø');
        $serialized = SerializationHelper::serialize($object);
        $this->assertEquals('{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","custom_fields":{"key.with.\\\special?char s*":"\u00e5\u00e4\u00f6\u00f8"},"date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}', $serialized);
    }

    /**
     * Tests that an object SKUs are serialized to HTML correctly
     */
    public function testObjectWithSkus()
    {
        $object = new MockProductWithSku();
        $serialized = SerializationHelper::serialize($object);
        $this->assertEquals('{"alternate_image_urls":["http:\/\/shop.com\/product_alt.jpg"],"availability":"InStock","brand":"Super Brand","categories":["\/Mens","\/Mens\/Shoes"],"condition":"Used","date_published":"2013-03-05","description":"This is a full description","google_category":"All","gtin":"gtin","image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":50,"list_price":110.99,"name":"Test Product","price":99.99,"price_currency_code":"USD","product_id":1,"rating_value":2.5,"review_count":99,"skus":[{"availability":"InStock","gtin":"gtin","id":100,"image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":20,"list_price":110.99,"name":"Test Product","price":99.99,"url":"http:\/\/my.shop.com\/products\/test_product.html"},{"availability":"InStock","custom_fields":{"noSnakeCase":"value"},"gtin":"gtin","id":100,"image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":20,"list_price":110.99,"name":"Test Product","price":99.99,"url":"http:\/\/my.shop.com\/products\/test_product.html"},{"availability":"InStock","custom_fields":{"\u00e5\u00e4\u00f6":"\u00e5\u00e4\u00f6"},"gtin":"gtin","id":100,"image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","inventory_level":20,"list_price":110.99,"name":"Test Product","price":99.99,"url":"http:\/\/my.shop.com\/products\/test_product.html"}],"supplier_cost":22.33,"tag1":["first"],"tag2":["second"],"tag3":["third"],"url":"http:\/\/my.shop.com\/products\/test_product.html","variation_id":"USD","variations":[]}', $serialized);
    }

    /**
     * Tests that an object SKUs are serialized to HTML correctly
     */
    public function testSkuIsSanitized()
    {
        $object = new MockSku();
        $object = $object->sanitize();
        $serialized = SerializationHelper::serialize($object);
        $this->assertEquals('{"availability":"InStock","gtin":"gtin","id":100,"image_url":"http:\/\/my.shop.com\/images\/test_product.jpg","list_price":110.99,"name":"Test Product","price":99.99,"url":"http:\/\/my.shop.com\/products\/test_product.html"}', $serialized);
    }

    /**
     * Tests that an object SKUs are serialized to HTML correctly
     */
    public function testAttributeOrderHasNoEffect()
    {
        $object1 = new MockProduct();
        $object1->addCustomField('0_custom_0', '0 value 0');
        $object1->addCustomField('1_custom_1', '1 value 1');
        $object1->addCustomField('custom_1', 'value 1');
        $object1->addCustomField('custom_2', 'value 2');
        $object2 = new MockProduct();
        $object2->addCustomField('custom_2', 'value 2');
        $object2->addCustomField('custom_1', 'value 1');
        $object2->addCustomField('1_custom_1', '1 value 1');
        $object2->addCustomField('0_custom_0', '0 value 0');

        $serialized1 = SerializationHelper::serialize($object1);
        $serialized2 = SerializationHelper::serialize($object2);

        $this->assertEquals($serialized1, $serialized2);
    }
}
