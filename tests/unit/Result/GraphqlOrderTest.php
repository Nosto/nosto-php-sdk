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
use Nosto\Result\Graphql\Result;

class GraphqlOrderTest extends Test
{
    use Specify;

    /**
     * Tests that errors are handled correctly
     */
    public function testBuildingResultWithErrors()
    {
        $resultBody = '{"data":{"updateStatus":null},"errors":[{"message":"Exception while fetching data (/updateStatus) : Unable to find order matching identifier","path":["updateStatus"],"locations":[{"line":7,"column":13}],"extensions":null,"errorType":"DataFetchingException"}]}';
        $response = new HttpResponse([], $resultBody);
        try {
            Result::parseResult($response);
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), "Exception while fetching data (/updateStatus) : Unable to find order matching identifier");
        }
    }

    /**
     * Tests that order id can be parsed from response body
     */
    public function testSuccessfullyCreateNewOrder()
    {
        $responseBody = '{"data":{"placeOrder":{"id":"5d1f2ebc10e62df62401221"}}}';
        $response = new HttpResponse([], $responseBody);
        $result = Result::parseResult($response);

        $this->specify('Order was created successfully', function () use ($result){
            $this->assertEquals($result, '5d1f2ebc10e62df62401221');
        });
    }

    /**
     * Tests that order number can be parsed from response body
     */
    public function testSuccessfullyUpdateExistingOrder()
    {
        $responseBody = '{"data":{"updateStatus":{"number":"M2_22","statuses":[{"date":"2019-07-08T11:58:12.540Z","orderStatus":"hold","paymentProvider":"klarna"},{"date":"2019-07-08T13:14:20.400Z","orderStatus":"hold","paymentProvider":"klarna"},{"date":"2019-07-08T13:26:43.479Z","orderStatus":"hold","paymentProvider":"klarna"}]}}}';
        $response = new HttpResponse([], $responseBody);
        $result = Result::parseResult($response);

        $this->specify('Order status was updates successfully', function () use ($result){
            $this->assertEquals($result, 'M2_22');
        });
    }
}