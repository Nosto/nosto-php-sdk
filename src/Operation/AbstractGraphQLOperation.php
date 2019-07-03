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

use Nosto\Nosto;
use Nosto\NostoException;
use Nosto\Request\Api\Token;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Exception\Builder as ExceptionBuilder;
use Nosto\Request\Http\Exception\HttpResponseException;
use Nosto\Request\Graphql\GraphqlRequest;
use Nosto\Request\Http\HttpResponse;
use Nosto\Operation\GraphQLRequest as GraphQLQuery;
use Nosto\Types\Signup\AccountInterface;

abstract class AbstractGraphQLOperation extends AbstractOperation
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
     * Removes line breaks from the string
     *
     * @return null|string|string[]
     */
    public function removeLineBreaks($string)
    {
        return preg_replace('/[\r\n]+/', '', $string);
    }

    /**
     * Returns the result
     *
     * @return HttpResponse
     * @throws AbstractHttpException
     * @throws HttpResponseException
     * @throws NostoException
     */
    public function execute()
    {
        $request = $this->initGraphqlRequest();
        $payload = new GraphQLQuery(
            $this->removeLineBreaks($this->getQuery()),
            $this->getVariables()
        );
        $payload = $payload->getRequest();
        $response = $request->postRaw(
            $payload
        );
        if ($response->getCode() !== 200) {
            throw ExceptionBuilder::fromHttpRequestAndResponse($request, $response);
        }

        return $response;
    }

    /**
     * Create and returns a new Graphql request object initialized with a content-type
     * of 'application/json' and the specified authentication token
     *
     * @return GraphqlRequest the newly created request object.
     * @throws NostoException if the account does not have the correct token set.
     * @throws NostoException
     */
    public function initGraphqlRequest()
    {
        $token = $this->account->getApiToken(Token::API_GRAPHQL);
        if (is_null($token)) {
            throw new NostoException('No API / Graphql token found for account.');
        }

        $request = new GraphqlRequest();
        $request->setResponseTimeout($this->getResponseTimeout());
        $request->setConnectTimeout($this->getConnectTimeout());
        $request->setAuthBasic('', $token->getValue());
        $request->setContentType(self::CONTENT_TYPE_APPLICATION_JSON);
        $request->setUrl(Nosto::getGraphqlBaseUrl() . GraphqlRequest::PATH_GRAPH_QL);

        return $request;
    }

    /**
     * Builds the recommendation API request
     *
     * @return string
     */
    abstract public function getQuery();

    /**
     * @return mixed
     */
    abstract public function getVariables();
}