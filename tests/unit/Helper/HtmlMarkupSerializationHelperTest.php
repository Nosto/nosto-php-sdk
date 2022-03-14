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

namespace Nosto\Test\Unit\Helper;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Model\Cart\Cart;
use Nosto\Model\PageType;
use Nosto\Model\SearchTerm;
use Nosto\Test\Support\MockBuyer;
use Nosto\Test\Support\MockLineItem;
use Nosto\Test\Support\MockOrder;
use Nosto\Test\Support\MockOrderStatus;
use Nosto\Test\Support\MockProduct;
use Nosto\Test\Support\MockCategory;
use Nosto\Test\Support\MockCustomer;
use Nosto\Test\Support\MockProductWithSku;
use Nosto\Test\Support\MockSku;
use Nosto\Test\Support\MockVariation;

class HtmlMarkupSerializationHelperTest extends Test
{
    use Specify;

    /**
     * Tests that a product object is serialized to HTML correctly
     */
    public function testProduct()
    {
        $object = new MockProduct();
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">Test Product</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description">This is a full description</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">    </span>    <span class="variations">    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that a category object is serialized to HTML correctly
     */
    public function testCategory()
    {
        $object = new MockCategory();
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_category" style="display:none">    <span class="category_string">/Women/New Arrivals</span>    <span class="id">10</span>    <span class="parent_id">4</span>    <span class="name">New Arrivals</span>    <span class="url">http://magento1.dev.nos.to/women/women-new-arrivals.html</span>    <span class="image_url">http://magento1.dev.nos.to/media/catalog/category/plp-w-newarrivals_1.jpg</span>    <span class="visible_in_menu">1</span>    <span class="level">3</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that a category object with html is serialized to HTML correctly
     */
    public function testCategoryWithHtml()
    {
        $object = new MockCategory();
        $object->setName('<p>Name with html</p>');
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_category" style="display:none">    <span class="category_string">/Women/New Arrivals</span>    <span class="id">10</span>    <span class="parent_id">4</span>    <span class="name">&lt;p&gt;Name with html&lt;/p&gt;</span>    <span class="url">http://magento1.dev.nos.to/women/women-new-arrivals.html</span>    <span class="image_url">http://magento1.dev.nos.to/media/catalog/category/plp-w-newarrivals_1.jpg</span>    <span class="visible_in_menu">1</span>    <span class="level">3</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that a customer object is serialized to HTML correctly
     */
    public function testCustomer()
    {
        $object = new MockCustomer();
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_customer" style="display:none">    <span class="first_name">Robot</span>    <span class="last_name">Test</span>    <span class="email">robot@test.com</span>    <span class="marketing_permission"></span>    <span class="gender">Male</span>    <span class="date_of_birth">1994-12-11</span>    <span class="region">Uusima</span>    <span class="city">Helsinki</span>    <span class="street">Bulevardi</span>    <span class="customer_reference">f9b62f795be96d31b8fbf9.40894994</span>    <span class="hcid">8c390967d210cca5a3eeb2d0c4c7990be8ecaf3d9680b752df4b90f7c89937a9</span>    <span class="customer_group">General</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that a customer object containing inline html is serialized to HTML correctly
     */
    public function testCustomerWithHtml()
    {
        $object = new MockCustomer();
        $object->setFirstName('<div>Robot</div>');
        $object->setCustomerGroup('<div>General</div>');
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_customer" style="display:none">    <span class="first_name">&lt;div&gt;Robot&lt;/div&gt;</span>    <span class="last_name">Test</span>    <span class="email">robot@test.com</span>    <span class="marketing_permission"></span>    <span class="gender">Male</span>    <span class="date_of_birth">1994-12-11</span>    <span class="region">Uusima</span>    <span class="city">Helsinki</span>    <span class="street">Bulevardi</span>    <span class="customer_reference">f9b62f795be96d31b8fbf9.40894994</span>    <span class="hcid">8c390967d210cca5a3eeb2d0c4c7990be8ecaf3d9680b752df4b90f7c89937a9</span>    <span class="customer_group">&lt;div&gt;General&lt;/div&gt;</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that an object is serialized to HTML correctly
     */
    public function testProductWithAltImages()
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

        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">Test Product</span>    <span class="image_url">http://my.shop.com/images/test_product_image.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description">This is a full description</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>      <span class="alternate_image_url">http://shop.com/product_alt_1.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">    </span>    <span class="variations">    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that an object with custom fields is serialized to HTML correctly
     */
    public function testObjectWithCustomFields()
    {
        $object = new MockProduct();
        $object->addCustomField('customFieldNoSnakeCase', 'value');
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">Test Product</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description">This is a full description</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">    </span>    <span class="variations">    </span>    <span class="custom_fields">      <span class="customFieldNoSnakeCase">value</span>    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that an object with custom fields that contains HTML tags is serialized to HTML correctly
     * Tests that single and double quotes are parsed correctly
     */
    public function testObjectWithCustomFieldContainingHtml()
    {
        //Case 1:
        //Custom attributes as string
        $object = new MockProduct();
        $object->addCustomField('customFieldOne', '<h1 class="test-class">Header One</h1>');
        $object->addCustomField('customFieldTwo', "<h1 class='test-class'>Header Two</h1>");
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">Test Product</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description">This is a full description</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">    </span>    <span class="variations">    </span>    <span class="custom_fields">      <span class="customFieldOne">&lt;h1 class=&quot;test-class&quot;&gt;Header One&lt;/h1&gt;</span>      <span class="customFieldTwo">&lt;h1 class=&#039;test-class&#039;&gt;Header Two&lt;/h1&gt;</span>    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));

        //Case 2:
        //Custom attributes as string and array
        $object = new MockProduct();
        $nestedArray = ['name' => 'Nested Array', 'description' => '<p>Testing nested array</p>'];
        $object->addCustomField('customFieldOne', '<h1 class="test-class">Header One</h1>');
        $object->addCustomField('customFieldTwo', "<h1 class='test-class'>Header Two</h1>");
        $object->addCustomField('customFieldThree', [$nestedArray]);
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">Test Product</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description">This is a full description</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">    </span>    <span class="variations">    </span>    <span class="custom_fields">      <span class="customFieldOne">&lt;h1 class=&quot;test-class&quot;&gt;Header One&lt;/h1&gt;</span>      <span class="customFieldTwo">&lt;h1 class=&#039;test-class&#039;&gt;Header Two&lt;/h1&gt;</span>      <span class="customFieldThree">        <span class="customFieldThree">          <span class="name">Nested Array</span>          <span class="description">&lt;p&gt;Testing nested array&lt;/p&gt;</span>        </span>      </span>    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that an object with custom fields and disabled autoEncoding is encoded and serialized correctly
     */
    public function testObjectWithSelectedVarsToEncode()
    {
        $object = new MockProduct();
        $object->setName('<h2>Test Product</h2>');
        $object->setDescription('<div>Product Description</div>');
        $object->disableAutoEncodeAll();
        $object->setVarsToEncode(['name']);
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">&lt;h2&gt;Test Product&lt;/h2&gt;</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description"><div>Product Description</div></span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">    </span>    <span class="variations">    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Test that Nosto\NostoException exception is thrown when declaring custom vars to encode that are nested
     */
    public function testErrorThrowingForVarsToEncode()
    {
        $this->expectException('Nosto\NostoException');
        $object = new MockProduct();
        $object->addCustomField('customFieldOne', '<h1 class="test-class">Header One</h1>');
        $object->addCustomField('customFieldTwo', "<h1 class='test-class'>Header Two</h1>");
        $object->disableAutoEncodeAll();
        $object->setVarsToEncode(['customFieldOne']);
        $object->toHtml();
    }

    /**
     * Tests that an object with key that contains special characters is serialized to HTML correctly
     */
    public function testObjectWithSpecialCharacters()
    {
        $object = new MockProduct();
        $object->addCustomField('key.with.\special?char s*', 'åäöø');
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">Test Product</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description">This is a full description</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">    </span>    <span class="variations">    </span>    <span class="custom_fields">      <span class="key.with.\special?char s*">åäöø</span>    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that an object with scandic custom fields is serialized to HTML correctly
     */
    public function testObjectWithScandicCustomFields()
    {
        $object = new MockProduct();
        $object->addCustomField('åäö', 'åäö');
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">Test Product</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description">This is a full description</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">    </span>    <span class="variations">    </span>    <span class="custom_fields">      <span class="åäö">åäö</span>    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that an object with SKUs is serialized to HTML correctly
     */
    public function testObjectWithSkus()
    {
        $object = new MockProductWithSku();
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">Test Product</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>    </span>    <span class="description">This is a full description</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>    </span>    <span class="tags2">      <span class="tag">second</span>    </span>    <span class="tags3">      <span class="tag">third</span>    </span>    <span class="google_category">All</span>    <span class="skus">      <span class="nosto_sku">        <span class="id">100</span>        <span class="name">Test Product</span>        <span class="price">99.99</span>        <span class="list_price">110.99</span>        <span class="url">http://my.shop.com/products/test_product.html</span>        <span class="image_url">http://my.shop.com/images/test_product.jpg</span>        <span class="gtin">gtin</span>        <span class="availability">InStock</span>      </span>      <span class="nosto_sku">        <span class="id">100</span>        <span class="name">Test Product</span>        <span class="price">99.99</span>        <span class="list_price">110.99</span>        <span class="url">http://my.shop.com/products/test_product.html</span>        <span class="image_url">http://my.shop.com/images/test_product.jpg</span>        <span class="gtin">gtin</span>        <span class="availability">InStock</span>        <span class="custom_fields">          <span class="noSnakeCase">value</span>        </span>      </span>      <span class="nosto_sku">        <span class="id">100</span>        <span class="name">Test Product</span>        <span class="price">99.99</span>        <span class="list_price">110.99</span>        <span class="url">http://my.shop.com/products/test_product.html</span>        <span class="image_url">http://my.shop.com/images/test_product.jpg</span>        <span class="gtin">gtin</span>        <span class="availability">InStock</span>        <span class="custom_fields">          <span class="åäö">åäö</span>        </span>      </span>    </span>    <span class="variations">    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * @param $string
     * @return null|string|string[]
     */
    private static function stripLineBreaks($string)
    {
        return preg_replace("/[\r\n]/", "", $string);
    }

    /**
     * Tests that an object with custom fields is serialized to HTML correctly
     */
    public function testProductWithHtmlAttributes()
    {
        $object = new MockProduct();
        $object->addCustomField('customFieldWithHtml', '<p><script>alert("alerting from custom field");</script></p>');
        $object->addCategory('<p><script>alert("alerting from category");</script></p>');
        $object->addTag1('<p><script>alert("alerting from tag1");</script></p>');
        $object->addTag2('<p><script>alert("alerting from tag2");</script></p>');
        $object->addTag3('<p><script>alert("alerting from tag3");</script></p>');
        $object->setName('<p><script>alert("alerting from name");</script></p>');
        $object->setDescription('<p>This is an HTML block</p>');

        $sku = new MockSku();
        $sku->setName('<p>HTML in name</p>');
        $sku->addCustomField('htmlField', '<script>alert("alert from sku custom field");</script>');
        $sku->enableAutoEncodeAll();
        $object->addSku($sku);

        $variation = new MockVariation();
        $variation->setPriceCurrencyCode('<p>EUR</p>');
        $variation->enableAutoEncodeAll();
        $object->addVariation($variation);

        $object->enableAutoEncodeAll();
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_product" style="display:none">    <span class="url">http://my.shop.com/products/test_product.html</span>    <span class="product_id">1</span>    <span class="name">&lt;p&gt;&lt;script&gt;alert(&quot;alerting from name&quot;);&lt;/script&gt;&lt;/p&gt;</span>    <span class="image_url">http://my.shop.com/images/test_product.jpg</span>    <span class="price">99.99</span>    <span class="list_price">110.99</span>    <span class="price_currency_code">USD</span>    <span class="availability">InStock</span>    <span class="categories">      <span class="category">/Mens</span>      <span class="category">/Mens/Shoes</span>      <span class="category">&lt;p&gt;&lt;script&gt;alert(&quot;alerting from category&quot;);&lt;/script&gt;&lt;/p&gt;</span>    </span>    <span class="description">&lt;p&gt;This is an HTML block&lt;/p&gt;</span>    <span class="brand">Super Brand</span>    <span class="variation_id">USD</span>    <span class="review_count">99</span>    <span class="rating_value">2.5</span>    <span class="alternate_image_urls">      <span class="alternate_image_url">http://shop.com/product_alt.jpg</span>    </span>    <span class="condition">Used</span>    <span class="gtin">gtin</span>    <span class="tags1">      <span class="tag">first</span>      <span class="tag">&lt;p&gt;&lt;script&gt;alert(&quot;alerting from tag1&quot;);&lt;/script&gt;&lt;/p&gt;</span>    </span>    <span class="tags2">      <span class="tag">second</span>      <span class="tag">&lt;p&gt;&lt;script&gt;alert(&quot;alerting from tag2&quot;);&lt;/script&gt;&lt;/p&gt;</span>    </span>    <span class="tags3">      <span class="tag">third</span>      <span class="tag">&lt;p&gt;&lt;script&gt;alert(&quot;alerting from tag3&quot;);&lt;/script&gt;&lt;/p&gt;</span>    </span>    <span class="google_category">All</span>    <span class="skus">      <span class="nosto_sku">        <span class="id">100</span>        <span class="name">&lt;p&gt;HTML in name&lt;/p&gt;</span>        <span class="price">99.99</span>        <span class="list_price">110.99</span>        <span class="url">http://my.shop.com/products/test_product.html</span>        <span class="image_url">http://my.shop.com/images/test_product.jpg</span>        <span class="gtin">gtin</span>        <span class="availability">InStock</span>        <span class="custom_fields">          <span class="htmlField">&lt;script&gt;alert(&quot;alert from sku custom field&quot;);&lt;/script&gt;</span>        </span>      </span>    </span>    <span class="variations">      <span class="variation">        <span class="variation_id">1</span>        <span class="price">99.99</span>        <span class="list_price">110.99</span>        <span class="price_currency_code">&lt;p&gt;EUR&lt;/p&gt;</span>        <span class="availability">InStock</span>      </span>    </span>    <span class="custom_fields">      <span class="customFieldWithHtml">&lt;p&gt;&lt;script&gt;alert(&quot;alerting from custom field&quot;);&lt;/script&gt;&lt;/p&gt;</span>    </span>    <span class="date_published">2013-03-05</span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that a page type object containing inline html is serialized to HTML correctly
     */
    public function testPageType()
    {
        $object = new PageType('<p>Page type with html</p>');
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_page_type" style="display:none">&lt;p&gt;Page type with html&lt;/p&gt;</span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that a search object containing inline html is serialized to HTML correctly
     */
    public function testSearch()
    {
        $object = new SearchTerm('<p>Search term with html</p>');
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_search_term" style="display:none">&lt;p&gt;Search term with html&lt;/p&gt;</span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that a cart containing inline html is serialized to HTML correctly
     */
    public function testCart()
    {
        $object = new Cart();
        $lineItem = new MockLineItem();
        $lineItem->setName('<p>Line item with HTML</p>');
        $object->addItem($lineItem);
        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none">  <span class="nosto_cart" style="display:none">    <span class="items">      <span class="line_item">        <span class="product_id">1</span>        <span class="quantity">2</span>        <span class="name">&lt;p&gt;Line item with HTML&lt;/p&gt;</span>        <span class="unit_price">99.99</span>        <span class="price_currency_code">USD</span>      </span>    </span>  </span></div>', self::stripLineBreaks($markup));
    }

    /**
     * Tests that an order object containing inline html is serialized to HTML correctly
     */
    public function testOrder()
    {
        $object = new MockOrder();
        $object->setExternalOrderRef('<p>external ref</p>');

        $lineItem = new MockLineItem();
        $lineItem->setName('<p>Line item with HTML</p>');
        $object->addPurchasedItems($lineItem);

        $orderStatus = new MockOrderStatus();
        $orderStatus->setCode('<div>completed</div>');
        $orderStatus->enableAutoEncodeAll();
        $object->setOrderStatus($orderStatus);

        $buyer = new MockBuyer();
        $buyer->setFirstName('<b>First name</b>');
        $object->setCustomer($buyer);

        $markup = $object->toHtml();
        $this->assertEquals('<div class="notranslate" style="display:none"> <span class="nosto_purchase_order" style="display:none"> <span class="order_number">123</span> <span class="created_at">2014-12-12 10:15:15</span> <span class="payment_provider">test-gateway [1.0.0]</span> <span class="buyer"> <span class="first_name">&lt;b&gt;First name&lt;/b&gt;</span> <span class="last_name">Kirk</span> <span class="email">james.kirk@example.com</span> <span class="marketing_permission"></span> </span> <span class="purchased_items"> <span class="line_item"> <span class="product_id">1</span> <span class="quantity">2</span> <span class="name">Test Product</span> <span class="unit_price">99.99</span> <span class="price_currency_code">USD</span> </span> <span class="line_item"> <span class="product_id">-1</span> <span class="quantity">1</span> <span class="name">Discount</span> <span class="unit_price">123.45</span> <span class="price_currency_code">EUR</span> </span> <span class="line_item"> <span class="product_id">1</span> <span class="quantity">2</span> <span class="name">&lt;p&gt;Line item with HTML&lt;/p&gt;</span> <span class="unit_price">99.99</span> <span class="price_currency_code">USD</span> </span> </span> <span class="order_status_code">&lt;div&gt;completed&lt;/div&gt;</span> <span class="order_status_label">Completed</span> <span class="external_order_ref">&lt;p&gt;external ref&lt;/p&gt;</span> </span></div>', self::stripLineBreaks($markup));
    }
}
