<?php
/**
 * Copyright (c) 2016, Nosto Solutions Ltd
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
 * @copyright 2016 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

require_once(dirname(__FILE__) . '/../_support/MockNostoProduct.php');
require_once(dirname(__FILE__) . '/../_support/MockNostoOrder.php');

class HistoryExportTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var NostoAccountInterface
     */
    protected $account;

    /**
     * Tests that product history data can be exported.
     */
    public function testProductHistoryExport()
    {
        $collection = new NostoExportProductCollection();
        $collection[] = new MockNostoProduct();
        $cipher_text = NostoExporter::export($this->account, $collection);

        $this->specify('verify encrypted product export', function () use ($collection, $cipher_text) {
            $cipher = new NostoCipher();
            $cipher->setSecret('01098d0fc84ded7c');
            $cipher->setIV(substr($cipher_text, 0, 16));
            $plain_text = $cipher->decrypt(substr($cipher_text, 16));

            $this->assertEquals($collection->getJson(), $plain_text);
        });
    }

    /**
     * Tests that order history data can be exported.
     */
    public function testOrderHistoryExport()
    {
        $collection = new NostoExportOrderCollection();
        $collection->append(new MockNostoOrder());
        $cipher_text = NostoExporter::export($this->account, $collection);

        $this->specify('verify encrypted order export', function () use ($collection, $cipher_text) {
            $cipher = new NostoCipher();
            $cipher->setSecret('01098d0fc84ded7c');
            $cipher->setIV(substr($cipher_text, 0, 16));
            $plain_text = $cipher->decrypt(substr($cipher_text, 16));

            $this->assertEquals($collection->getJson(), $plain_text);
        });
    }

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        $this->account = new NostoAccount('platform-00000000');
        // The first 16 chars of the SSO token are used as the encryption key.
        $token = new NostoApiToken('sso', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
        $this->account->addApiToken($token);
    }
}
