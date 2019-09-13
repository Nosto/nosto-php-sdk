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

namespace Nosto\Test\Unit\Serialization;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Object\Product\Product;
use Nosto\Test\Support\MockProduct;
use Nosto\Test\Support\MockSkuCollection;
use Nosto\Test\Support\MockVariationCollection;
use Nosto\Util\Serializer\Json as JsonSerializer;

class JsonTest extends Test
{
    use Specify;

    /**
     * Tests that an product object is serialized correctly
     */
    public function testProductSerialization()
    {
        $product = new MockProduct();
        $mainImage = 'http://my.shop.com/images/test_product_image.jpg';
        $altImages = [
            $mainImage,
            'http://shop.com/product_alt.jpg',
            'http://shop.com/product_alt.jpg',
            'http://shop.com/product_alt_1.jpg',
        ];

        $product->setAlternateImageUrls($altImages);
        $product->setImageUrl($mainImage);
        $skus = new MockSkuCollection();
        $product->setSkus($skus);
        $variations = new MockVariationCollection();
        $product->setVariations($variations);

        $expected = '{"url":"http:\/\/my.shop.com\/products\/test_product.html","productId":1,"name":"Test Product","imageUrl":"http:\/\/my.shop.com\/images\/test_product_image.jpg","price":99.99,"listPrice":110.99,"priceCurrencyCode":"USD","availability":"InStock","categories":["\/Mens","\/Mens\/Shoes"],"description":"This is a full description","brand":"Super Brand","variationId":"USD","supplierCost":22.33,"inventoryLevel":50,"reviewCount":99,"ratingValue":2.5,"alternateImageUrls":["http:\/\/shop.com\/product_alt.jpg","http:\/\/shop.com\/product_alt_1.jpg"],"condition":"Used","gender":null,"ageGroup":null,"gtin":"gtin","tag1":["first"],"tag2":["second"],"tag3":["third"],"googleCategory":"All","unitPricingMeasure":null,"unitPricingBaseMeasure":null,"unitPricingUnit":null,"skus":[{"id":1,"name":"Test Product I","price":79.99,"listPrice":100.99,"url":"http:\/\/my.shop.com\/products\/test_product_1.html","imageUrl":"http:\/\/my.shop.com\/images\/test_product_1.jpg","gtin":"gtin1","availability":"InStock","customFields":[],"inventoryLevel":20},{"id":2,"name":"Test Product","price":59.99,"listPrice":200.99,"url":"http:\/\/my.shop.com\/products\/test_product_2.html","imageUrl":"http:\/\/my.shop.com\/images\/test_product_2.jpg","gtin":"gtin2","availability":"OutOfStock","customFields":[],"inventoryLevel":15},{"id":3,"name":"Test Product","price":22.99,"listPrice":33.99,"url":"http:\/\/my.shop.com\/products\/test_product_3.html","imageUrl":"http:\/\/my.shop.com\/images\/test_product_3.jpg","gtin":"gtin4","availability":"InStock","customFields":[],"inventoryLevel":5}],"variations":[{"variationId":"USD_1","price":99.99,"listPrice":110.99,"priceCurrencyCode":"USD","availability":"InStock"},{"variationId":"EUR_2","price":69.99,"listPrice":99.99,"priceCurrencyCode":"EUR","availability":"InStock"},{"variationId":"SEK_3","price":990.99,"listPrice":1100.99,"priceCurrencyCode":"SEK","availability":"OutOfStock"}],"thumbUrl":null,"customFields":[],"datePublished":"2013-03-05"}';
        $serialized = JsonSerializer::serialize($product);
        $this->assertEquals($expected, $serialized);
    }

    /**
     * Tests that valid data can be deserialized to a product object
     */
    public function testProductDeserialization()
    {
        $data = '{"url":"http:\/\/my.shop.com\/products\/test_product.html","productId":1,"name":"Test Product","imageUrl":"http:\/\/my.shop.com\/images\/test_product_image.jpg","price":99.99,"listPrice":110.99,"priceCurrencyCode":"USD","availability":"InStock","categories":["\/Mens","\/Mens\/Shoes"],"description":"This is a full description","brand":"Super Brand","variationId":"USD","supplierCost":22.33,"inventoryLevel":50,"reviewCount":99,"ratingValue":2.5,"alternateImageUrls":["http:\/\/shop.com\/product_alt.jpg","http:\/\/shop.com\/product_alt_1.jpg"],"condition":"Used","gender":null,"ageGroup":null,"gtin":"gtin","tag1":["first"],"tag2":["second"],"tag3":["third"],"googleCategory":"All","unitPricingMeasure":null,"unitPricingBaseMeasure":null,"unitPricingUnit":null,"skus":[{"id":1,"name":"Test Product I","price":79.99,"listPrice":100.99,"url":"http:\/\/my.shop.com\/products\/test_product_1.html","imageUrl":"http:\/\/my.shop.com\/images\/test_product_1.jpg","gtin":"gtin1","availability":"InStock","customFields":[],"inventoryLevel":20},{"id":2,"name":"Test Product","price":59.99,"listPrice":200.99,"url":"http:\/\/my.shop.com\/products\/test_product_2.html","imageUrl":"http:\/\/my.shop.com\/images\/test_product_2.jpg","gtin":"gtin2","availability":"OutOfStock","customFields":[],"inventoryLevel":15},{"id":3,"name":"Test Product","price":22.99,"listPrice":33.99,"url":"http:\/\/my.shop.com\/products\/test_product_3.html","imageUrl":"http:\/\/my.shop.com\/images\/test_product_3.jpg","gtin":"gtin4","availability":"InStock","customFields":[],"inventoryLevel":5}],"variations":[{"variationId":"USD_1","price":99.99,"listPrice":110.99,"priceCurrencyCode":"USD","availability":"InStock"},{"variationId":"EUR_2","price":69.99,"listPrice":99.99,"priceCurrencyCode":"EUR","availability":"InStock"},{"variationId":"SEK_3","price":990.99,"listPrice":1100.99,"priceCurrencyCode":"SEK","availability":"OutOfStock"}],"thumbUrl":null,"customFields":[],"datePublished":"2013-03-05"}';
        $product = JsonSerializer::deserialize($data, Product::class);
        $mockProduct = new MockProduct();
        $serialized = JsonSerializer::serialize($product);
//        $this->assertEquals($product, $mockProduct);
    }
}
