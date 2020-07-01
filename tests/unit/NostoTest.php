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

namespace Nosto\Test\Unit;

use Codeception\TestCase\Test;
use Exception;
use Nosto\Request\Http\HttpRequest;
use Nosto\Request\Http\HttpResponse;
use Nosto\Request\Api\Exception\ApiResponseException;
use Nosto\Exception\Builder as ExceptionBuilder;

class NostoTest extends Test
{
    /**
     * Tests that errors are parsed correctly from http response
	 * @throws Exception
     */
    public function testExceptionErrors()
    {
        $request = new HttpRequest();

        $response = new HttpResponse(
            [
                'HTTP/1.1 400 Bad Request',
                'Content-Type: text/plain; charset=utf-8'
            ],
            /** @lang text */
            '{"type":"has_errors","message":"Failed to upsert some products; see errors","errors":[{"product_id":"1","errors":"image_url field is missing (imageUrl), Validation failed (), "}]}'
        );
        try {
            throw ExceptionBuilder::fromHttpRequestAndResponse($request, $response);
        } catch (ApiResponseException $exception) {
            $this->assertEquals('Failed to upsert some products; see errors | image_url field is missing (imageUrl), Validation failed (), (product #1)', $exception->getMessage());
        }
    }
}
