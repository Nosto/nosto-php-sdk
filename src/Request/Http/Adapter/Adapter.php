<?php
/**
 * Copyright (c) 2017, Nosto Solutions Ltd
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
 * @copyright 2017 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Request\Http\Adapter;

use Nosto\Request\Http\HttpResponse;

/**
 * Base class for all http request adapters.
 */
abstract class Adapter
{
    const CRLF = "\r\n";

    /**
     * @var int timeout for waiting response from the api, in second
     */
    private $responseTimeout = 5;

    /**
     * @var int timeout for connecting to the api, in second
     */
    private $connectTimeout = 5;

    /**
     * @var array the request headers.
     */
    protected $headers = array();

    /**
     * @var mixed the request content.
     */
    protected $content = null;

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Does a GET request and returns the http response object.
     *
     * @param string $url the URL to request.
     * @param array $options the request options.
     * @return HttpResponse the response object.
     */
    abstract public function get($url, array $options = array());

    /**
     * Does a POST request and returns the http response object.
     *
     * @param string $url the URL to request.
     * @param array $options the request options.
     * @return HttpResponse the response object.
     */
    abstract public function post($url, array $options = array());

    /**
     * Does a PUT request and returns the http response object.
     *
     * @param string $url the URL to request.
     * @param array $options the request options.
     * @return HttpResponse the response object.
     */
    abstract public function put($url, array $options = array());

    /**
     * Does a DELETE request and returns the http response object.
     *
     * @param string $url the URL to request.
     * @param array $options the request options.
     * @return HttpResponse the response object.
     */
    abstract public function delete($url, array $options = array());

    /**
     * Initializes the request options.
     *
     * @param array $options the options.
     */
    protected function init(array $options = array())
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Get response timeout in second
     * @return int response timeout in second
     */
    public function getResponseTimeout()
    {
        return $this->responseTimeout;
    }

    /**
     * Set response timeout in second
     * @param int $responseTimeout in second
     */
    public function setResponseTimeout($responseTimeout)
    {
        $this->responseTimeout = $responseTimeout;
    }

    /**
     * connect timeout in second
     * @return int connect timeout in second
     */
    public function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    /**
     * Set connect timeout in second
     * @param int $connectTimeout in second
     */
    public function setConnectTimeout($connectTimeout)
    {
        $this->connectTimeout = $connectTimeout;
    }
}
