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
use Nosto\Model\Signup\Account;
use Nosto\Request\Api\Token;

class AccountTest extends Test
{
    use Specify;

    /**
     * Tests the "isConnectedToNosto" method for the NostoAccount class.
     */
    public function testAccountIsConnected()
    {
        $account = new Account('platform-test');

        $this->specify('account is not connected', function () use ($account) {
            $this->assertFalse($account->isConnectedToNosto());
        });

        $token = new Token('sso', '123');
        $account->addApiToken($token);

        $token = new Token('products', '123');
        $account->addApiToken($token);

        $this->specify('account is connected', function () use ($account) {
            $this->assertTrue($account->isConnectedToNosto());
        });
    }

    /**
     * Tests the "getApiToken" method for the NostoAccount class.
     */
    public function testAccountApiToken()
    {
        $account = new Account('platform-test');

        $this->specify('account does not have sso token', function () use ($account) {
            $this->assertNull($account->getApiToken('sso'));
        });

        $token = new Token('sso', '123');
        $account->addApiToken($token);

        $this->specify('account has sso token', function () use ($account) {
            $this->assertEquals('123', $account->getApiToken('sso')->getValue());
        });
    }
}
