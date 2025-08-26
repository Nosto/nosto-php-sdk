<?php
/**
 * Copyright (c) 2025, Nosto Solutions Ltd
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

namespace Nosto\Operation\Search;

use GuzzleHttp\Client;
use Nosto\Model\Analytics\AnalyticsSearchMetadataForGraphql;
use Nosto\NostoException;
use Nosto\Operation\AbstractGraphQLOperation;
use Nosto\Request\Api\SearchAnalyticsRequest;
use Nosto\Result\Api\GeneralPurposeResultHandler;

class AnalyticsSearchTrackingGraphql extends AbstractGraphQLOperation
{
    /**
     * @type string
     */
    private $merchantId;
    /**
     * @type string
     */
    private $sessionId;
    /**
     * @type string
     */
    private $path;
    /**
     * @type string | null
     */
    private $userAgent;

    private $appToken;

    private $page;

    private $productIds;

    private $metadata;

    const APP_URL = 'https://api.nosto.com/v1/graphql';

    private $client;
    /**
     * @param string $merchantId
     * @param string $sessionId
     * @param string $userAgent
     * @param string $appToken
     */
    public function __construct($merchantId, $sessionId, $userAgent, $appToken)
    {
        $this->merchantId = $merchantId;
        $this->sessionId = $sessionId;
        $this->userAgent = $userAgent;
        $this->appToken = $appToken;

        $this->client = new Client();
    }

    /**
     * Tracks search analytics.
     *a
     * @param AnalyticsSearchMetadataForGraphql $metadata
     * @param string $productId
     * @return void
     * @throws NostoException
     */
    public function click(AnalyticsSearchMetadataForGraphql $metadata, $productId)
    {
        $this->setPath(SearchAnalyticsRequest::PATH_SEARCH_CLICK);
        try {
            $requestParams = ["merchant" => $this->merchantId, "customer" => $this->sessionId];
            $request = $this->initRequest(
                null,
                null,
                null,
                false,
                $requestParams
            );
            if ($this->userAgent) {
                $request->addUserAgentHeader($this->userAgent);
            }
            $response = $request->postRaw(json_encode([
                'metadata' => $metadata,
                'productId' => $productId
            ]));

            if ($response->getCode() !== 200) {
                throw new NostoException('Failed to send search analytics click data. Status code: ' . $response->getCode());
            }
        } catch (\Exception $e) {
            throw new NostoException('Error sending search analytics click data: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Tracks search analytics.
     *
     * @param AnalyticsSearchMetadataForGraphql $metadata
     * @param array $productIds
     * @param int $page
     * @return void
     * @throws NostoException
     */
    public function impression(AnalyticsSearchMetadataForGraphql $metadata, $productIds, $page)
    {
        $this->setPath('https://api.nosto.com/v1/graphql');
        try {
            $this->page = $page;
            $this->productIds = $productIds;
            $this->metadata = $metadata;

            $response = $this->client->post(self::APP_URL, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'auth' => ['', $this->appToken],
                'body' => json_encode([
                    'query' => $this->getQuery(),
                    'variables' => $this->getVariables(),
                ]),
            ]);

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                throw new NostoException('Failed to send search analytics impression data. Status code: ' . $response->getCode());
            }
        } catch (\Exception $e) {
            throw new NostoException('Error sending search analytics impression data: ' . $e->getMessage(), 0, $e);
        }
    }

    protected function getResultHandler()
    {
        return new GeneralPurposeResultHandler();
    }

    /**
     * @inheritdoc
     */
    protected function getRequestType()
    {
        return new SearchAnalyticsRequest();
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
        return $this->path;
    }

    protected function setPath($path)
    {
        $this->path = $path;
    }


    /**
     * @return string
     */
    public function getQuery()
    {
        return <<<QUERY
            mutation(
              \$id: String!,
              \$page: Int!,
              \$productIds: [String]!,
              \$metadata: InputSearchEventMetadataInputEntity!,
              \$timestamp: String!
            ) {
              recordAnalyticsEvent(
                id: \$id,
                by: BY_REF,
                params: {
                  type: SEARCH,
                  timestamp: \$timestamp,
                  searchImpression: {
                    page: \$page,
                    productIds: \$productIds,
                    metadata: \$metadata
                  }
                }
              )
            }
QUERY;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return [
            'id' => $this->sessionId,
            'page' => $this->page,
            'productIds' => $this->productIds,
            'metadata' => $this->metadata,
            'timestamp' => gmdate('c'),
        ];
    }

}