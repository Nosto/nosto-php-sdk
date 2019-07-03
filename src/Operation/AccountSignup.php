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

namespace Nosto\Operation;

use Nosto\NostoException;
use Nosto\Object\Signup\Account;
use Nosto\Request\Api\ApiRequest;
use Nosto\Request\Api\Token;
use Nosto\Types\Signup\AccountInterface;
use Nosto\Types\Signup\SignupInterface;

/**
 * Operation class for handling the creation accounts through the Nosto API.
 */
class AccountSignup extends AbstractRESTOperation
{
    /**
     * @var SignupInterface Nosto account meta
     */
    private $account;

    /**
     * Constructor.
     *
     * @param SignupInterface $account the Nosto account object.
     */
    public function __construct(SignupInterface $account)
    {
        $this->account = $account;
        //Account creation takes time
        $this->setResponseTimeout(60);
    }

    /**
     * Sends a POST request to create a new account for a store in Nosto
     *
     * @return AccountInterface if the request was successful.
     * @throws NostoException on failure.
     */
    public function create()
    {
        $request = $this->initRequest($this->account->getSignUpApiToken());
        $request->setReplaceParams(array('{lang}' => $this->account->getLanguageCode()));
        $response = $request->post($this->account);
        self::checkResponse($request, $response);

        $account = new Account($this->account->getPlatform() . '-' . $this->account->getName());
        $account->setTokens(Token::parseTokens(
            $response->getJsonResult(true),
            '',
            '_token'
        ));
        return $account;
    }

    /**
     * @inheritdoc
     */
    protected function getPath()
    {
        return ApiRequest::PATH_SIGN_UP;
    }

    /**
     * @inheritdoc
     */
    public function getRequestType()
    {
        return new ApiRequest();
    }

    /**
     * @inheritdoc
     */
    public function getMimoType()
    {
        return self::CONTENT_TYPE_APPLICATION_JSON;
    }
}
