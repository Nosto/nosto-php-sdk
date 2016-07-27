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

require_once(dirname(__FILE__) . '/../_support/MockNostoAccountIframe.php');

class IframeAuthTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests that we can build an authenticated url for the config iframe.
     */
    public function testIframeUrlAuthentication()
    {
        /** @var NostoAccount $account */
        $account = new MockNostoConfiguration('platform-00000000');
        $meta = new MockNostoAccountIframe();
        $baseUrl = isset($_ENV['NOSTO_WEB_HOOK_BASE_URL']) ? $_ENV['NOSTO_WEB_HOOK_BASE_URL'] : NostoHttpRequest::$baseUrl;

        $url = $account->getIframeUrl($meta);
        $this->specify('install iframe url was created', function () use ($url, $baseUrl) {
            $this->assertEquals($baseUrl . '/hub/platform/install?lang=en&ps_version=1.0.0&nt_version=1.0.0&product_pu=http%3A%2F%2Fmy.shop.com%2Fproducts%2Fproduct123%3Fnostodebug%3Dtrue&category_pu=http%3A%2F%2Fmy.shop.com%2Fproducts%2Fcategory123%3Fnostodebug%3Dtrue&search_pu=http%3A%2F%2Fmy.shop.com%2Fsearch%3Fquery%3Dred%3Fnostodebug%3Dtrue&cart_pu=http%3A%2F%2Fmy.shop.com%2Fcart%3Fnostodebug%3Dtrue&front_pu=http%3A%2F%2Fmy.shop.com%3Fnostodebug%3Dtrue&shop_lang=en&shop_name=Shop+Name&unique_id=123&fname=James&lname=Kirk&email=james.kirk%40example.com', $url);
        });
        $token = new NostoApiToken('sso', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
        $account->addApiToken($token);
        $url = $account->getIframeUrl($meta);
        $this->specify('auth iframe url was created', function () use ($url) {
            $this->assertEquals(
                'https://nosto.com/auth/sso/sso%2Bplatform-00000000@nostosolutions.com/xAd1RXcmTMuLINVYaIZJJg?lang=en&ps_version=1.0.0&nt_version=1.0.0&product_pu=http%3A%2F%2Fmy.shop.com%2Fproducts%2Fproduct123%3Fnostodebug%3Dtrue&category_pu=http%3A%2F%2Fmy.shop.com%2Fproducts%2Fcategory123%3Fnostodebug%3Dtrue&search_pu=http%3A%2F%2Fmy.shop.com%2Fsearch%3Fquery%3Dred%3Fnostodebug%3Dtrue&cart_pu=http%3A%2F%2Fmy.shop.com%2Fcart%3Fnostodebug%3Dtrue&front_pu=http%3A%2F%2Fmy.shop.com%3Fnostodebug%3Dtrue&shop_lang=en&shop_name=Shop+Name&unique_id=123&fname=James&lname=Kirk&email=james.kirk%40example.com',
                $url
            );
        });
    }
}
