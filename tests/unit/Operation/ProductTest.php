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
use Nosto\Object\Signup\Account;
use Nosto\Operation\UpsertProduct;
use Nosto\Request\Api\Token;

class OperationProductTest extends Test
{
    use Specify;

    /**
     * Tests that product upsert API requests cannot be made without an API token.
     */
    public function testSendingProductUpsertWithoutApiToken()
    {
        $account = new Account('platform-00000000');
        $product = new MockProduct();

        $this->expectException('Nosto\NostoException');
        $op = new UpsertProduct($account);
        $op->addProduct($product);
        $op->upsert();
    }

    /**
     * Tests that product upsert API requests can be made.
     */
    public function testSendingProductUpsert()
    {
        $account = new Account('platform-00000000');
        $product = new MockProduct();
        $token = new Token('products', 'token');
        $account->addApiToken($token);

        $op = new UpsertProduct($account);
        $op->addProduct($product);
        $result = $op->upsert();

        $this->specify('successful product upsert', function () use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that product upsert API requests can be made.
     */
    public function testSendingProductSku()
    {
        $account = new Account('platform-00000000');
        $product = new MockProduct();
        $sku = new MockSku();
        $sku->setName("xxxx");
        $product->addSku($sku);
        $this->assertCount(1, $product->getSkus());
        $sku = new MockSku();
        $sku->setId(3);
        $product->addSku($sku);
        $this->assertCount(2, $product->getSkus());
        $token = new Token('products', 'token');
        $account->addApiToken($token);

        $op = new UpsertProduct($account);
        $op->addProduct($product);
        $result = $op->upsert();

        $this->specify('successful product upsert', function () use ($result) {
            $this->assertTrue($result);
        });
    }
}
