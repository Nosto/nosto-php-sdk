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

namespace Nosto\Test\Unit\Result;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Exception;
use Nosto\Request\Http\HttpResponse;
use Nosto\Request\Http\HttpRequest;
use Nosto\Result\Graphql\Recommendation\RecommendationResultHandler;
use Nosto\Result\Graphql\Recommendation\CategoryMerchandisingResult;

class GraphqlCMPTest extends Test
{
    use Specify;

    /**
     * Tests that a valid result set can be built
	 * @throws Exception
     */
    public function testBuildingValidResultSet()
    {
        $responseBody = '{ "data": { "updateSession": { "id": "5d481e38c10ea0f265eb2f5c", "recos": { "category": { "primary": [ { "productId": "276", "priceText": "€42.00", "name": "Beaumont Summit Kit", "imageUrl": "https://nailgun.dev.nos.to/quick/magento-e4fde459/10/276/09896ff88fcd5bdfc3b2104fb2e3b20982e232d3d102d3087eea57004b6de40ba/A", "url": "http://magento2.dev.nos.to/beaumont-summit-kit.html" }, { "productId": "292", "priceText": "€51.00", "name": "Hyperion Elements Jacket", "imageUrl": "https://nailgun.dev.nos.to/quick/magento-e4fde459/10/292/84065088529bf50501c637a95ad2062d0e0bb4f3061df11b4b2448c26cd32cb9a/A", "url": "http://magento2.dev.nos.to/hyperion-elements-jacket.html" } ], "batchToken": "n2MyOTL7AAAAAAAAAAD/", "totalPrimaryCount": 10, "resultId": "graphql" } } } } }';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());
        /** @var CategoryMerchandisingResult $resultSet */
        $resultSet = $request->getResultHandler()->parse($response);

        $this->specify('result set parsed', function () use ($resultSet) {
            $this->assertEquals(2, $resultSet->getResultSet()->count());
        });
    }

    /**
     * Tests that a valid result set can be built
	 * @throws Exception
     */
    public function testBuildingValidResultId()
    {
        $responseBody = '{ "data": { "updateSession": { "id": "5d481e38c10ea0f265eb2f5c", "recos": { "category": { "primary": [ { "productId": "276", "priceText": "€42.00", "name": "Beaumont Summit Kit", "imageUrl": "https://nailgun.dev.nos.to/quick/magento-e4fde459/10/276/09896ff88fcd5bdfc3b2104fb2e3b20982e232d3d102d3087eea57004b6de40ba/A", "url": "http://magento2.dev.nos.to/beaumont-summit-kit.html" }, { "productId": "292", "priceText": "€51.00", "name": "Hyperion Elements Jacket", "imageUrl": "https://nailgun.dev.nos.to/quick/magento-e4fde459/10/292/84065088529bf50501c637a95ad2062d0e0bb4f3061df11b4b2448c26cd32cb9a/A", "url": "http://magento2.dev.nos.to/hyperion-elements-jacket.html" } ], "batchToken": "n2MyOTL7AAAAAAAAAAD/", "totalPrimaryCount": 10, "resultId": "graphql" } } } } }';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());
        /** @var CategoryMerchandisingResult $resultSet */
        $resultSet = $request->getResultHandler()->parse($response);

        $this->specify('result set parsed', function () use ($resultSet) {
            $this->assertEquals('graphql', $resultSet->getTrackingCode());
        });
    }

    /**
     * Tests exception is thrown for invalid payload
     */
    public function testBuildingMissingCategory()
    {
        $responseBody = '{"data":{"updateSession":{"recos":{"category_ids":{"nonprimary":[{"productId":"558"},{"productId":"386"},{"productId":"414"},{"productId":"435"},{"productId":"399"},{"productId":"382"},{"productId":"867"},{"productId":"383"},{"productId":"560"},{"productId":"551"}]}}}}}';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());

        $this->specify('result does not contain primary field', function () use ($request,$response) {
            try {
                $request->getResultHandler()->parse($response);
                $this->fail('No exception was thrown');
            } catch (Exception $e) {
                $this->assertEquals('Could not find field for category data from response', $e->getMessage());
            }
        });
    }

    /**
     * Tests exception is thrown for invalid payload
     */
    public function testBuildingMissingPrimary()
    {
        $responseBody = '{ "data": { "updateSession": { "id": "5d481e38c10ea0f265eb2f5c", "recos": { "category": { "batchToken": "n2MyOTL7AAAAAAAAAAD/", "totalPrimaryCount": 10, "resultId": "graphql" } } } } }';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());

        $this->specify('result does not contain primary field', function () use ($request,$response) {
            try {
                $request->getResultHandler()->parse($response);
                $this->fail('No exception was thrown');
            } catch (Exception $e) {
                $this->assertEquals('Could not find field for primary data from response', $e->getMessage());
            }
        });
    }

    /**
     * Tests that no exception is thrown when result id is missing
     */
    public function testBuildingResponseForMissing()
    {
        $responseBody = '{ "data": { "session": { "id": "5d481e38c10ea0f265eb2f5c", "recos": { "category": { "primary": [], "totalPrimaryCount": 0 } } } } }';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());

        /** @var CategoryMerchandisingResult $resultSet */
        $resultSet = $request->getResultHandler()->parse($response);

        $this->specify('result does not contain resultId', function () use ($resultSet) {
            $this->assertEquals($resultSet->getResultSet()->count(), 0);
        });
    }
}
