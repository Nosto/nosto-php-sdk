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
use Nosto\NostoException;
use Nosto\Request\Http\HttpResponse;
use Nosto\Request\Http\HttpRequest;
use Nosto\Result\Graphql\Session\SessionResultHandler;

class GraphqlSessionTest extends Test
{
    use Specify;

    /**
     * Tests that session id is parsed correctly
     * @throws Exception
     */
    public function testSessionIdParsing()
    {
        $responseBody = '{ "data": { "newSession": "6176a09a73533e5d8bdad3fa" } }';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new SessionResultHandler());
        $result = $request->getResultHandler()->parse($response);

        $this->specify('Session was created successfully', function () use ($result) {
            $this->assertEquals('6176a09a73533e5d8bdad3fa', $result);
        });
    }

    /**
     * Tests when session id is empty
     */
    public function testSessionIdParsingWhenEmpty()
    {
        $dataType = SessionResultHandler::GRAPHQL_DATA_SESSION;
        $responseBody = '{ "data": {} }';
        $response = new HttpResponse(['HTTP/1.1 200 OK'], $responseBody);
        $request = new HttpRequest();
        $request->setResultHandler(new SessionResultHandler());
        try {
            $request->getResultHandler()->parse($response);
        } catch (Exception $e) {
            $this->assertEquals('Could not find field for ' . $dataType . ' data from response', $e->getMessage());
        }
    }
}
