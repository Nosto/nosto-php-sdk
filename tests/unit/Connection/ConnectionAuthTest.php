<?php /** @noinspection DuplicatedCode */

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

namespace Nosto\Test\Unit\Connection;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Mixins\ConnectionTrait;
use Nosto\Nosto;
use Nosto\Request\Api\Token;
use Nosto\Test\Support\MockConnectionMetadata;
use Nosto\Test\Support\MockUser;
use Nosto\Test\Support\MockAccount;

class ConnectionAuthTest extends Test
{
    use Specify;
    use ConnectionTrait;

    private $user;
    private $account;
    private $connection;

    /**
     * Test that when no account at all is given, the connection mixin returns the uninstallation URL
     * @noinspection DuplicatedCode
     */
    public function testConnectionUrlWithoutAccount()
    {
        $this->connection = new MockConnectionMetadata();
        $this->user = new MockUser();
        $this->account = null;

        $baseUrl = Nosto::getBaseUrl();
        $url = self::buildURL();
        $this->specify('Nosto install url was created', function () use ($url, $baseUrl) {
            $url = parse_url($url);
            parse_str($url['query'], $params);


            $this->assertEquals($url['scheme'], parse_url($baseUrl)['scheme']);
            $this->assertEquals($url['host'], parse_url($baseUrl)['host']);
            $this->assertEquals('/hub/platform/install', $url['path']);
            $this->assertEquals('en', $params['lang']);
            $this->assertEquals('1.0.0', $params['ps_version']);
            $this->assertEquals('0.1.0', $params['nt_version']);
            $this->assertEquals('en', $params['shop_lang']);
            $this->assertEquals('Shop Name', $params['shop_name']);
            $this->assertEquals('James', $params['fname']);
            $this->assertEquals('Kirk', $params['lname']);
            $this->assertEquals('james.kirk@example.com', $params['email']);
        });
    }

    /**
     * Test that when an account with all the expected SSO tokens is given, the connection mixin
     * returns the correct URL
     */
    public function testConnectionWithAccount()
    {
        $this->connection = new MockConnectionMetadata();
        $this->user = new MockUser();
        $this->account = new MockAccount();
        $token = new Token('sso', 'token');
        $this->account->addApiToken($token);

        $baseUrl = Nosto::getBaseUrl();
        $url = self::buildURL();
        $this->specify('Nosto install url was created', function () use ($url, $baseUrl) {
            $url = parse_url($url);
            parse_str($url['query'], $params);

            $this->assertEquals($url['scheme'], parse_url($baseUrl)['scheme']);
            $this->assertNotEquals($url['host'], parse_url($baseUrl)['host']);
            $this->assertContains('/hub/magento/platform-00000000/', $url['path']);
            $this->assertEquals('en', $params['lang']);
            $this->assertEquals('1.0.0', $params['ps_version']);
            $this->assertEquals('0.1.0', $params['nt_version']);
            $this->assertEquals('en', $params['shop_lang']);
            $this->assertEquals('Shop Name', $params['shop_name']);
            $this->assertEquals('James', $params['fname']);
            $this->assertEquals('Kirk', $params['lname']);
            $this->assertEquals('james.kirk@example.com', $params['email']);
        });
    }

    /**
     * Test that when an account with missing or incorrect API tokens are given, the connection mixin
     * returns the uninstallation URL
     */
    public function testConnectionWithErrors()
    {
        $this->connection = new MockConnectionMetadata();
        $this->user = new MockUser();
        $this->account = new MockAccount();

        $baseUrl = Nosto::getBaseUrl();
        $url = self::buildURL();
        $this->specify('Nosto install url was created', function () use ($url, $baseUrl) {
            $url = parse_url($url);
            parse_str($url['query'], $params);

            $this->assertEquals($url['scheme'], parse_url($baseUrl)['scheme']);
            //$this->assertEquals($url['host'], parse_url($baseUrl)['host']);
            $this->assertEquals('/hub/platform/uninstall', $url['path']);
            $this->assertEquals('en', $params['lang']);
            $this->assertEquals('1.0.0', $params['ps_version']);
            $this->assertEquals('0.1.0', $params['nt_version']);
            $this->assertEquals('en', $params['shop_lang']);
            $this->assertEquals('Shop Name', $params['shop_name']);
            $this->assertEquals('James', $params['fname']);
            $this->assertEquals('Kirk', $params['lname']);
            $this->assertEquals('james.kirk@example.com', $params['email']);
            $this->assertEquals('No API token found for account.', $params['message_text']);
            $this->assertEquals('error', $params['message_type']);
            $this->assertEquals('account_delete', $params['message_code']);
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
    public function getConnectionMetadata()
    {
        return $this->connection;
    }
}
