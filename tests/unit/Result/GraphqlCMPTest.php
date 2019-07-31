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

namespace Nosto\Test\Unit\Result;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Request\Http\HttpResponse;
use Nosto\Request\Http\HttpRequest;
use Nosto\Result\Graphql\Recommendation\RecommendationResultHandler;
use Nosto\Result\ResultHandler;

class GraphqlCMPTest extends Test
{
    use Specify;

    /**
     * Tests that a valid result set can be built
     */
    public function testBuildingValidResultSet()
    {
        $responseBody = '{"data":{"updateSession":{"recos":{"category_ids":{"primary":[{"productId":"558"},{"productId":"386"},{"productId":"414"},{"productId":"435"},{"productId":"399"},{"productId":"382"},{"productId":"867"},{"productId":"383"},{"productId":"560"},{"productId":"551"}]}}}}}';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());
        $resultSet = $request->getResponseHandler()->parse($response);

        $this->specify('result set parsed', function () use ($resultSet) {
            $this->assertEquals($resultSet->count(), 10);
        });
    }

    /**
     * Tests that valid result set with nested arrays can be built
     */
    public function testBuildingValidResultSetWithNestedArray()
    {
        $responseBody = '{"data":{"updateSession":{"recos":{"category_ids":{"primary":[{"productId":"558", "categories":["Men/Stuff", "Men/Summer"]}]}}}}}';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());
        $resultSet = $request->getResponseHandler()->parse($response);
        $this->specify('nested array parsing failed', function () use ($resultSet) {
            $this->assertEquals($resultSet->count(), 1);
            foreach ($resultSet as $item) {
                $categories = $item->getCategories();
                $this->assertInternalType('array', $categories);
            }
        });
    }

    /**
     * Tests that valid result set with nested objects can be built
     */
    public function testBuildingValidResultSetWithNestedObject()
    {
        $responseBody = '{"data":{"updateSession":{"recos":{"category_ids":{"primary":[{"productId":"558", "categories":["Men/Stuff", "Men/Summer"], "customObject":{"id":1, "name":"test object"}}]}}}}}';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());
        $resultSet = $request->getResponseHandler()->parse($response);

        $this->specify('nested object failed', function () use ($resultSet) {
            $this->assertEquals($resultSet->count(), 1);
            foreach ($resultSet as $item) {
                $object = $item->getCustomObject();
                $this->assertInternalType('array', $object);
            }
        });
    }

    /**
     * Tests exception is thrown for invalid payload
     */
    public function testBuildingMissingPrimary()
    {
        $responseBody = '{"data":{"updateSession":{"recos":{"category_ids":{"nonprimary":[{"productId":"558"},{"productId":"386"},{"productId":"414"},{"productId":"435"},{"productId":"399"},{"productId":"382"},{"productId":"867"},{"productId":"383"},{"productId":"560"},{"productId":"551"}]}}}}}';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new RecommendationResultHandler());

        $this->specify('result does not contain primary field', function () use ($request,$response) {
            try {
                $request->getResponseHandler()->parse($response);
                $this->fail('No exception was thrown');
            } catch (\Exception $e) {
                $this->assertEquals($e->getMessage(), 'Could not find primary data field primary from response');
            }
        });
    }
}