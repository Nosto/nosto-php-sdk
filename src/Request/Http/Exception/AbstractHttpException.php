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

namespace Nosto\Request\Http\Exception;

use Exception;
use Nosto\NostoException;
use Nosto\Request\Http\HttpRequest;
use Nosto\Request\Http\HttpResponse;

/**
 * Nosto exception class for HTTP errors within the SDK.
 */
abstract class AbstractHttpException extends NostoException
{
    /**
     * @var HttpResponse|null
     */
    private $response;

    /**
     * @var HttpRequest|null
     */
    private $request;

    /**
     * HttpException constructor.
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     * @param HttpRequest|null $request
     * @param HttpResponse|null $response
     */
    public function __construct(
        $message = "",
        $code = 0,
        Exception $previous = null,
        HttpRequest $request = null,
        HttpResponse $response = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param HttpRequest $request
     */
    public function setRequest(HttpRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return HttpResponse
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param HttpResponse $response
     */
    public function setResponse(HttpResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Get x request id from the response
     * @return null|string
     */
    public function getXRequestId()
    {
        if ($this->response != null) {
            return $this->response->getXRequestId();
        }

        return null;
    }
}
