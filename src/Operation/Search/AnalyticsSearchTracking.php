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
 * @copyright 2020 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Operation\Search;

use GuzzleHttp\Client;
use Nosto\Model\Analytics\AnalyticsTrackingPayload;
use Nosto\Model\Analytics\DataSource;
use Nosto\SDK\Api\Request\Exception\HttpRequestException;

class AnalyticsSearchTracking extends AbstractGraphQLOperation
{
    private const ENDPOINT = '/analytics/search/track';

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Tracks search analytics.
     *
     * @param DataSource $dataSource
     * @param AnalyticsTrackingPayload $payload
     * @throws HttpRequestException
     */
    public function track(DataSource $dataSource, AnalyticsTrackingPayload $payload): void
    {
        try {
            $response = $this->client->post(self::ENDPOINT, [
                'json' => [
                    'dataSource' => $dataSource->getType(),
                    'metadata' => [
                        'query' => $payload->getQuery(),
                        'productNumber' => $payload->getProductNumber(),
                        'resultId' => $payload->getResultId(),
                        'isOrganic' => $payload->isOrganic(),
                        'isAutoCorrect' => $payload->isAutoCorrect(),
                        'isAutoComplete' => $payload->isAutoComplete(),
                        'isKeyword' => $payload->isKeyword(),
                        'isSorted' => $payload->isSorted(),
                        'hasResults' => $payload->hasResults(),
                        'isRefined' => $payload->isRefined(),
                    ],
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new HttpRequestException('Failed to send search analytics data. Status code: ' . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            throw new HttpRequestException('Error sending search analytics data: ' . $e->getMessage(), 0, $e);
        }
    }
}

