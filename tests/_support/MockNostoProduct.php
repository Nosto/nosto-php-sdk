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

class MockNostoProduct extends NostoProduct
{

    public function __construct()
    {
        parent::__construct();
        $this->setDescription('This is a full description');
        $this->setTag1(array('first'));
        $this->setTag2(array('second'));
        $this->setTag3(array('third'));
        $this->setUrl('http://my.shop.com/products/test_product.html');
        $this->setProductId(1);
        $this->setName('Test Product');
        $this->setImageUrl('http://my.shop.com/images/test_product.jpg');
        $this->setPrice(99.99);
        $this->setPriceCurrencyCode('USD');
        $this->setAvailability('InStock');
        $this->setCategories(array('/Mens', '/Mens/Shoes'));
        $this->setListPrice(110.99);
        $this->setBrand('Super Brand');
        $this->setVariationId("USD");
        $this->setSupplierCost(22.33);
        $this->setInventoryLevel(50);
        $this->setReviewCount(99);
        $this->setRatingValue(2.5);
        $this->setAlternateImageUrls(array("http://shop.com/product_alt.jpg"));
        $this->setCondition("Used");
        $this->setGtin("gtin");
        $this->setGoogleCategory("All");
    }

    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->{$getter}();
        }
        throw new Exception(sprintf('Property `%s.%s` is not defined.', get_class($this), $name));
    }
}
