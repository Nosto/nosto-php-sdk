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

namespace Nosto\Test\Unit;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Helper\ExportHelper;
use Nosto\Helper\SerializationHelper;
use Nosto\Object\Order\OrderCollection;
use Nosto\Object\Product\ProductCollection;
use Nosto\Object\Signup\Account;
use Nosto\Request\Api\Token;
use Nosto\Types\Signup\AccountInterface;
use phpseclib\Crypt\AES;
use phpseclib\Crypt\Base;
use Nosto\Test\Support\MockProduct;
use Nosto\Test\Support\MockOrder;

class HistoryExportTest extends Test
{
    use Specify;

    /**
     * @var AccountInterface
     */
    protected $account;

    /**
     * Tests that product history data can be exported.
     */
    public function testProductHistoryExport()
    {
        $collection = new ProductCollection();
        $collection->append(new MockProduct());
        $cipher_text = (new ExportHelper())->export($this->account, $collection);

        $this->specify('check encrypted product data', function () use ($collection, $cipher_text) {
            $cipher = new AES(Base::MODE_CBC);
            $cipher->setKey(substr($this->account->getApiToken('sso')->getValue(), 0, 16));
            $cipher->setIV(substr($cipher_text, 0, 16));
            $plain_text = $cipher->decrypt(substr($cipher_text, 16));

            $this->assertEquals(SerializationHelper::serialize($collection), $plain_text);
        });
    }

    /**
     * Tests that OrderConfirm history data can be exported.
     */
    public function testOrderHistoryExport()
    {
        $collection = new OrderCollection();
        $collection->append(new MockOrder());
        $cipher_text = (new ExportHelper())->export($this->account, $collection);

        $this->specify('check encrypted order data', function () use ($collection, $cipher_text) {
            $cipher = new AES(Base::MODE_CBC);
            $cipher->setKey(substr($this->account->getApiToken('sso')->getValue(), 0, 16));
            $cipher->setIV(substr($cipher_text, 0, 16));
            $plain_text = $cipher->decrypt(substr($cipher_text, 16));

            $this->assertEquals(SerializationHelper::serialize($collection), $plain_text);
        });
    }

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        $this->account = new Account('platform-00000000');
        $token = new Token('sso',
            '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
        $this->account->addApiToken($token);
    }
}
