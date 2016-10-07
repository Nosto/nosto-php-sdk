<?php
/**
 * Copyright (c) 2016, Nosto Solutions Ltd
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
 * @copyright 2016 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

/**
 * Adapter class for making http requests using curl.
 * This adapter requires curl to be installed.
 */
class NostoHttpRequestAdapterCurl extends NostoHttpRequestAdapter
{

    /**
     * @var string the user-agent to use if specified
     */
    private $userAgent = false;

    /**
     * Constructor.
     * Creates the http request adapter with the specified user-agent
     *
     * @param $userAgent string the user-agent header for all requests
     */
    public function __construct($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @inheritdoc
     */
    public function get($url, array $options = array())
    {
        $this->init($options);
        return $this->send(
            array(
                CURLOPT_URL => $url,
                CURLOPT_HEADER => 1,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
           )
        );
    }

    /**
     * @inheritdoc
     */
    public function post($url, array $options = array())
    {
        $this->init($options);
        return $this->send(
            array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $this->content,
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 1,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function put($url, array $options = array())
    {
        $this->init($options);
        return $this->send(
            array(
                CURLOPT_URL => $url,
                CURLOPT_POSTFIELDS => $this->content,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_HEADER => 1,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
            )
        );
    }

    /**
     * @inheritdoc
     */
    public function delete($url, array $options = array())
    {
        $this->init($options);
        return $this->send(
            array(
                CURLOPT_URL => $url,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_HEADER => 1,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
            )
        );
    }

    /**
     * Sends the request and creates a NostoHttpResponse instance containing the response headers and body.
     *
     * @param array $curlOptions options for curl_setopt_array().
     * @return NostoHttpResponse
     */
    protected function send(array $curlOptions)
    {
        if (!empty($this->headers)) {
            $curlOptions[CURLOPT_HTTPHEADER] = $this->headers;
        }
        if (!in_array(CURLOPT_USERAGENT, $curlOptions) && $this->userAgent) {
            $curlOptions[CURLOPT_USERAGENT] = $this->userAgent;
        }
        if (!in_array(CURLOPT_TIMEOUT, $curlOptions)) {
            $curlOptions[CURLOPT_TIMEOUT] = NostoHttpRequest::$responseTimeout;
        }
        if (!in_array(CURLOPT_CONNECTTIMEOUT, $curlOptions)) {
            $curlOptions[CURLOPT_CONNECTTIMEOUT] = NostoHttpRequest::$connectTimeout;
        }
        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        $result = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = explode("\r\n", substr($result, 0, $headerSize));
        $body = substr($result, $headerSize);
        $message = curl_error($ch);
        curl_close($ch);
        return new NostoHttpResponse($headers, $body, $message);
    }
}
