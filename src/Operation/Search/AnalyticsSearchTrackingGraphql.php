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

use Nosto\Model\Analytics\AnalyticsSearchMetadataForGraphql;
use Nosto\NostoException;
use Nosto\Operation\AbstractGraphQLOperation;
use Nosto\Result\Api\JsonResultHandler;
use Nosto\Types\Signup\AccountInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @type string
     */
    private $appToken;

    /**
     * @type int
     */
    private $page;

    /**
     * @type array
     */
    private $productIds;

    /**
     * @type string
     */
    private $productId;

    /**
     * @type AnalyticsSearchMetadataForGraphql
     */
    private $metadata;
    /**
     * @type string
     */
    private $query;
    /**
     * @type array
     */
    private $variables;

    /**
     * @param string $merchantId
     * @param string $sessionId
     * @param string $userAgent
     * @param string $appToken
     * @param AccountInterface $account
     * @param string $activeDomain
     */
    public function __construct($merchantId, $sessionId, $userAgent, $appToken, AccountInterface $account, $activeDomain = '')
    {
        parent::__construct($account, $activeDomain);

        $this->merchantId = $merchantId;
        $this->sessionId = $sessionId;
        $this->userAgent = $userAgent;
        $this->appToken = $appToken;
    }

    /**
     * Tracks search analytics.
     *
     * @param AnalyticsSearchMetadataForGraphql $metadata
     * @param array $productId
     * @return void
     * @throws NostoException
     */
    public function click(AnalyticsSearchMetadataForGraphql $metadata, $productId)
    {
        try {
            $this->productId = $productId;
            $this->metadata = $metadata;

            $this->setQuery(<<<QUERY
    mutation(
      \$id: String!,
      \$by: LookupParams!,
      \$productId: String!,
      \$metadata: InputSearchEventMetadataInputEntity!,
      \$timestamp: String!
    ) {
      recordAnalyticsEvent(
        id: \$id,
        by: \$by,
        params: {
          type: SEARCH,
          timestamp: \$timestamp,
          searchClick: {
            productId: \$productId,
            metadata: \$metadata
          }
        }
      )
    }
QUERY
            );

            $this->setVariables([
                'id' => $this->sessionId,
                'by' => self::IDENTIFIER_BY_REF,
                'productId' => $this->productId,
                'metadata' => $this->metadata,
                'timestamp' => gmdate('c'),
            ]);

            $response = $this->execute();
            if(!empty($response['errors'])) {
                throw new NostoException(json_encode($response['errors']));
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
        try {
            $this->page = $page;
            $this->productIds = $productIds;
            $this->metadata = $metadata;

            $this->setQuery(<<<QUERY
    mutation(
      \$id: String!,
      \$by: LookupParams!,
      \$page: Int!,
      \$productIds: [String]!,
      \$metadata: InputSearchEventMetadataInputEntity!,
      \$timestamp: String!
    ) {
      recordAnalyticsEvent(
        id: \$id,
        by: \$by,
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
QUERY
            );

            $this->setVariables([
                'id' => $this->sessionId,
                'by' => self::IDENTIFIER_BY_REF,
                'page' => $this->page,
                'productIds' => $this->productIds,
                'metadata' => $this->metadata,
                'timestamp' => gmdate('c'),
            ]);

            $response = $this->execute();
            if(!empty($response['errors'])) {
                throw new NostoException(json_encode($response['errors']));
            }
        } catch (\Exception $e) {
            throw new NostoException('Error sending search analytics impression data: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * @return void
     */
    private function setQuery($query)
    {
        $this->query = $query;
    }
    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    private function setVariables($variables)
    {
        $this->variables = $variables;
    }
    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    protected function getResultHandler()
    {
        return new JsonResultHandler();
    }

    protected function setPath($path)
    {
        $this->path = $path;
    }
}