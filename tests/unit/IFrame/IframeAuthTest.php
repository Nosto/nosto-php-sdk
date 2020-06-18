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

namespace Nosto\Test\Unit\IFrame;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Mixins\IframeTrait;
use Nosto\Nosto;
use Nosto\Request\Api\Token;
use Nosto\Request\Http\HttpRequest;
use Nosto\Test\Support\MockIframe;
use Nosto\Test\Support\MockUser;
use Nosto\Test\Support\MockAccount;

class IframeAuthTest extends Test
{
    use Specify;
    use IframeTrait;
    private $user;
    private $account;
    private $iframe;

    /**
     * Test that when no account at all is given, the Iframe mixin returns the uninstallation URL
     */
    public function testIframeUrlWithoutAccount()
    {
        $this->iframe = new MockIframe();
        $this->user = new MockUser();
        $this->account = null;

        $baseUrl = Nosto::getBaseUrl();
        $url = self::buildURL();
        $this->specify('install iframe url was created', function () use ($url, $baseUrl) {
            $url = parse_url($url);
            parse_str($url['query'], $params);


            $this->assertEquals($url['scheme'], parse_url($baseUrl)['scheme']);
            $this->assertEquals($url['host'], parse_url($baseUrl)['host']);
            $this->assertEquals($url['path'], '/hub/platform/install');
            $this->assertEquals($params['lang'], 'en');
            $this->assertEquals($params['ps_version'], '1.0.0');
            $this->assertEquals($params['nt_version'], '0.1.0');
            $this->assertEquals($params['product_pu'], 'http://shop.com/products?nostodebug=true');
            $this->assertEquals($params['category_pu'], 'http://shop.com/category?nostodebug=true');
            $this->assertEquals($params['search_pu'], 'http://shop.com/search?nostodebug=true');
            $this->assertEquals($params['cart_pu'], 'http://shop.com/cart?nostodebug=true');
            $this->assertEquals($params['front_pu'], 'http://shop.com?nostodebug=true');
            $this->assertEquals($params['shop_lang'], 'en');
            $this->assertEquals($params['shop_name'], 'Shop Name');
            $this->assertEquals($params['unique_id'], '123');
            $this->assertEquals($params['fname'], 'James');
            $this->assertEquals($params['lname'], 'Kirk');
            $this->assertEquals($params['email'], 'james.kirk@example.com');
        });
    }

    /**
     * Test that when an account with all the expected SSO tokens is given, the Iframe mixin
     * returns the correct URL
     */
    public function testIframeWithAccount()
    {
        $this->iframe = new MockIframe();
        $this->user = new MockUser();
        $this->account = new MockAccount('platform-00000000');
        $token = new Token('sso', 'token');
        $this->account->addApiToken($token);

        $baseUrl = Nosto::getBaseUrl();
        $url = self::buildURL();
        $this->specify('install iframe url was created', function () use ($url, $baseUrl) {
            $url = parse_url($url);
            parse_str($url['query'], $params);

            $this->assertEquals($url['scheme'], parse_url($baseUrl)['scheme']);
            $this->assertNotEquals($url['host'], parse_url($baseUrl)['host']);
            $this->assertContains('/hub/magento/platform-00000000/', $url['path']);
            $this->assertEquals($params['lang'], 'en');
            $this->assertEquals($params['ps_version'], '1.0.0');
            $this->assertEquals($params['nt_version'], '0.1.0');
            $this->assertEquals($params['product_pu'], 'http://shop.com/products?nostodebug=true');
            $this->assertEquals($params['category_pu'], 'http://shop.com/category?nostodebug=true');
            $this->assertEquals($params['search_pu'], 'http://shop.com/search?nostodebug=true');
            $this->assertEquals($params['cart_pu'], 'http://shop.com/cart?nostodebug=true');
            $this->assertEquals($params['front_pu'], 'http://shop.com?nostodebug=true');
            $this->assertEquals($params['shop_lang'], 'en');
            $this->assertEquals($params['shop_name'], 'Shop Name');
            $this->assertEquals($params['unique_id'], '123');
            $this->assertEquals($params['fname'], 'James');
            $this->assertEquals($params['lname'], 'Kirk');
            $this->assertEquals($params['email'], 'james.kirk@example.com');
        });
    }

    /**
     * Test that when an account with missing or incorrect API tokens are given, the Iframe mixin
     * returns the uninstallation URL
     */
    public function testIframeWithErrors()
    {
        $this->iframe = new MockIframe();
        $this->user = new MockUser();
        $this->account = new MockAccount('platform-00000000');

        $baseUrl = Nosto::getBaseUrl();
        $url = self::buildURL();
        $this->specify('install iframe url was created', function () use ($url, $baseUrl) {
            $url = parse_url($url);
            parse_str($url['query'], $params);

            $this->assertEquals($url['scheme'], parse_url($baseUrl)['scheme']);
            //$this->assertEquals($url['host'], parse_url($baseUrl)['host']);
            $this->assertEquals($url['path'], '/hub/platform/uninstall');
            $this->assertEquals($params['lang'], 'en');
            $this->assertEquals($params['ps_version'], '1.0.0');
            $this->assertEquals($params['nt_version'], '0.1.0');
            $this->assertEquals($params['product_pu'], 'http://shop.com/products?nostodebug=true');
            $this->assertEquals($params['category_pu'], 'http://shop.com/category?nostodebug=true');
            $this->assertEquals($params['search_pu'], 'http://shop.com/search?nostodebug=true');
            $this->assertEquals($params['cart_pu'], 'http://shop.com/cart?nostodebug=true');
            $this->assertEquals($params['front_pu'], 'http://shop.com?nostodebug=true');
            $this->assertEquals($params['shop_lang'], 'en');
            $this->assertEquals($params['shop_name'], 'Shop Name');
            $this->assertEquals($params['unique_id'], '123');
            $this->assertEquals($params['fname'], 'James');
            $this->assertEquals($params['lname'], 'Kirk');
            $this->assertEquals($params['email'], 'james.kirk@example.com');
            $this->assertEquals($params['message_text'], 'No API token found for account.');
            $this->assertEquals($params['message_type'], 'error');
            $this->assertEquals($params['message_code'], 'account_delete');
        });
    }

    /**
     * @inheritdoc
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @inheritdoc
     */
    public function getIframe()
    {
        return $this->iframe;
    }
}
