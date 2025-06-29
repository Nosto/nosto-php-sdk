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
 * @copyright 2025 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Operation;

use Nosto\NostoException;
use Nosto\Request\Api\Token;
use Nosto\Request\Graphql\SearchRequest;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Request\Http\Exception\HttpResponseException;
use Nosto\Types\Signup\AccountInterface;

abstract class AbstractSearchOperation extends AbstractOperation
{
    /**
     * @var AccountInterface Nosto configuration
     */
    protected $account;

    /**
     * @var string active domain
     */
    protected $activeDomain;

    /**
     * Constructor
     *
     * @param AccountInterface $account the account object.
     * @param string $activeDomain
     */
    public function __construct(AccountInterface $account, $activeDomain = '')
    {
        $this->account = $account;
        $this->activeDomain = $activeDomain;
    }

    /**
     * Returns the result
     *
     * @return mixed|null
     * @throws AbstractHttpException
     * @throws HttpResponseException
     * @throws NostoException
     */
    public function execute()
    {
        $request = $this->initRequest(
            $this->account->getApiToken(Token::API_SEARCH),
            $this->account->getName()
        );
        $payload = ['query' => $this->getQuery(), 'variables' => $this->getVariables()];
        $response = $request->postRaw(
            json_encode($payload)
        );

        return $request->getResultHandler()->parse($response);
    }

    /**
     * Returns the result, specific for Shopware.
     *
     * @return mixed|null
     * @throws AbstractHttpException
     * @throws HttpResponseException
     * @throws NostoException
     */
    public function executeSw()
    {

        $request = $this->initRequest(
            $this->account->getApiToken(Token::API_SEARCH),
            $this->account->getName()
        );

        $payload = ['query' => $this->getQuery(), 'variables' => $this->getVariables()];

        $response = $request->postRaw(
            json_encode($payload)
        );

        return [
            $response->getResult(),
            $request->getResultHandler()->parse($response)
        ];
    }

    /**
     * Builds the recommendation API request
     *
     * @return string
     */
    abstract public function getQuery();

    /**
     * @return array
     */
    abstract public function getVariables();

    /**
     * @inheritDoc
     */
    protected function initRequest(
        Token $token = null,
              $nostoAccount = null,
              $domain = null,
              $isTokenNeeded = true,
              $queryParams = null
    )
    {
        $request = parent::initRequest($token, $nostoAccount, $domain, false);

        $request->setAuthBearer($token->getValue());

        return $request;

    }

    /**
     * @inheritdoc
     */
    protected function getRequestType()
    {
        return new SearchRequest();
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
        return SearchRequest::PATH_SEARCH;
    }
}
