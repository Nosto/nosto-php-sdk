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
use Nosto\NostoException;
use Nosto\Request\Http\HttpRequest;
use Nosto\Request\Graphql\GraphqlRequest;

/**
 * Base operation class for handling all communications through the Nosto API.
 * Each endpoint is known as an operation in the SDK.
 */
abstract class AbstractOperation
{
    const CONTENT_TYPE_URL_FORM_ENCODED = 'application/x-www-form-urlencoded';
    const CONTENT_TYPE_APPLICATION_JSON = 'application/json';
    const CONTENT_TYPE_APPLICATION_GRAPHQL = 'application/graphql';

    /**
     * @var int timeout for waiting response from the api, in second
     */
    private $responseTimeout = 5;

    /**
     * @var int timeout for connecting to the api, in second
     */
    private $connectTimeout = 5;

    /**
     * @param Token|null $token
     * @param null $nostoAccount
     * @param null $domain
     * @return ApiRequest|GraphqlRequest|HttpRequest
     * @throws NostoException
     */
    protected function initRequest(
        Token $token = null,
        $nostoAccount = null,
        $domain = null
    ) {
        if (is_null($token)) {
            throw new NostoException('No API token found for account.');
        }
        $request = $this->getRequestType();
        if (is_string($domain)) {
            $request->setActiveDomainHeader($domain);
        }
        if (is_string($nostoAccount)) {
            $request->setNostoAccountHeader($nostoAccount);
        }
        $request->setResponseTimeout($this->getResponseTimeout());
        $request->setConnectTimeout($this->getConnectTimeout());
        $request->setContentType($this->getContentType());
        $request->setAuthBasic('', $token->getValue());
        $request->setPath($this->getPath());
        return $request;
    }

    /**
     * Return type of request object
     *
     * @return HttpRequest|ApiRequest|GraphqlRequest;
     */
    abstract protected function getRequestType();

    /**
     * Return content type
     *
     * @return string
     */
    abstract protected function getContentType();

    /**
     * @return string
     */
    abstract protected  function getPath();

    /**
     * Get response timeout in second
     * @return int response timeout in second
     */
    public function getResponseTimeout()
    {
        return $this->responseTimeout;
    }

    /**
     * Set response timeout in second
     * @param int $responseTimeout in second
     */
    public function setResponseTimeout($responseTimeout)
    {
        $this->responseTimeout = $responseTimeout;
    }

    /**
     * connect timeout in second
     * @return int connect timeout in second
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * Set connect timeout in second
     * @param int $connectTimeout in second
     */
    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;
    }
}
