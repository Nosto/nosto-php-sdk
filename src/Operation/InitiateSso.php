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

use Nosto\Request\Api\ApiRequest;
use Nosto\Request\Api\Token;
use Nosto\Request\Http\HttpRequest;
use Nosto\Types\UserInterface;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\NostoException;
use Nosto\Exception\Builder as ExceptionBuilder;

/**
 * Operation class for fetching a single-sign-on link through the Nosto API.
 * The operation results in a single-use URL that can be used for logging in
 * to the Nosto administration interface.
 */
class InitiateSso extends AbstractAuthenticatedOperation
{
    /**
     * Sends a POST request to get a single sign-on URL for a store
     *
     * @param UserInterface $user
     * @param $platform
     * @return string the sso URL if the request was successful.
     * @throws NostoException
     * @throws AbstractHttpException
     */
    public function get(UserInterface $user, $platform)
    {
        $request = $this->initRequest(
            $this->account->getApiToken(Token::API_SSO),
            $this->account->getName()
        );
        $request->setReplaceParams(array('{platform}' => $platform));
        $response = $request->post($user);
        if ($response->getCode() !== 200) {
            throw ExceptionBuilder::fromHttpRequestAndResponse($request, $response);
        }

        return $response->getJsonResult()->login_url;
    }

    /**
     * @inheritdoc
     */
    protected function getRequestType()
    {
        return new HttpRequest();
    }

    /**
     * @inheritdoc
     */
    protected function getContentType()
    {
        return self::CONTENT_TYPE_APPLICATION_JSON;
    }

    /**
     * @inheritdoc
     */
    protected function getPath()
    {
        return ApiRequest::PATH_SSO_AUTH;
    }

}
