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

namespace Nosto\Test\Support;

use \Nosto\Object\Product\Sku;
use Nosto\Object\Product\SkuCollection;

class MockSkuCollection extends SkuCollection
{
    public function __construct()
    {
        $sku1 = new Sku();
        $sku1->setAvailable(true);
        $sku1->setAvailability('InStock');
        $sku1->setGtin("gtin1");
        $sku1->setId(1);
        $sku1->setPrice(79.99);
        $sku1->setListPrice(100.99);
        $sku1->setUrl('http://my.shop.com/products/test_product_1.html');
        $sku1->setName('Test Product I');
        $sku1->setImageUrl('http://my.shop.com/images/test_product_1.jpg');
        $sku1->setInventoryLevel(20);
        $this->append($sku1);
        $sku2 = new Sku();
        $sku2->setAvailable(true);
        $sku2->setAvailability('OutOfStock');
        $sku2->setGtin("gtin2");
        $sku2->setId(2);
        $sku2->setPrice(59.99);
        $sku2->setListPrice(200.99);
        $sku2->setUrl('http://my.shop.com/products/test_product_2.html');
        $sku2->setName('Test Product');
        $sku2->setImageUrl('http://my.shop.com/images/test_product_2.jpg');
        $sku2->setInventoryLevel(15);
        $this->append($sku2);
        $sku3 = new Sku();
        $sku3->setAvailable(true);
        $sku3->setAvailability('InStock');
        $sku3->setGtin("gtin4");
        $sku3->setId(3);
        $sku3->setPrice(22.99);
        $sku3->setListPrice(33.99);
        $sku3->setUrl('http://my.shop.com/products/test_product_3.html');
        $sku3->setName('Test Product');
        $sku3->setImageUrl('http://my.shop.com/images/test_product_3.jpg');
        $sku3->setInventoryLevel(5);
        $this->append($sku3);
    }
}
