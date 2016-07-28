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

require_once(dirname(__FILE__) . '/../_support/MockNostoOAuthClientMetaData.php');

class AccountSyncOperationTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests that existing accounts can be synced from Nosto.
     * Accounts are synced using OAuth2 Authorization Code method.
     * We are only testing that we can start and act on the steps in the OAuth request cycle.
     */
    public function testSyncingExistingAccount()
    {
        $meta = new MockNostoOAuthClientMetaData();
        $client = new NostoOAuthClient($meta);

        $this->specify('oauth authorize url can be created', function () use ($client) {
            $this->assertEquals('http://localhost:3000?client_id=client-id&redirect_uri=http%3A%2F%2Fmy.shop.com%2Fnosto%2Foauth&response_type=code&scope=sso products&lang=en', $client->getAuthorizationUrl());
        });

        $service = new NostoOperationOauthSync($meta);
        $account = $service->exchange("test123");

        $this->specify('account was created', function () use ($account, $meta) {
            $this->assertInstanceOf('NostoAccount', $account);
            $this->assertEquals('platform-00000000', $account->getName());
        });

        $this->specify('account has api token sso', function () use ($account, $meta) {
            $token = $account->getApiToken('sso');
            $this->assertInstanceOf('NostoApiToken', $token);
            $this->assertEquals('sso', $token->getName());
            $this->assertNotEmpty($token->getValue());
        });

        $this->specify('account has api token products', function () use ($account, $meta) {
            $token = $account->getApiToken('products');
            $this->assertInstanceOf('NostoApiToken', $token);
            $this->assertEquals('products', $token->getName());
            $this->assertNotEmpty($token->getValue());
        });

        $this->specify('account is connected to nosto', function () use ($account, $meta) {
            $this->assertTrue($account->isConnectedToNosto());
        });
    }
}
