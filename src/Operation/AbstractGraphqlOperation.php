<?php
/**
 * Created by PhpStorm.
 * User: olsiqose
 * Date: 01/07/2019
 * Time: 16.39
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

abstract class AbstractGraphqlOperation extends AbstractAuthenticatedOperation
{

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