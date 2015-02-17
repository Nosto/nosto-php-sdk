<?php
/**
 * Copyright (c) 2015, Nosto Solutions Ltd
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
 * @copyright 2015 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 */

/**
 * Represents a http request response returned by NostoHttpRequest.
 */
class NostoHttpResponse
{
    /**
     * @var array the response headers if there are any.
     */
    protected $headers;

    /**
     * @var mixed the request result raw body.
     */
    protected $result;

    /**
     * @var string possible request error message.
     */
    protected $message;

    /**
     * Setter for the request response data.
     *
     * @param mixed $result the response data of the request.
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * Getter for the request response data.
     *
     * @return mixed the request response data.
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Setter for the error message of the request.
     *
     * @param string $message the message.
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Getter for the error message of the request.
     *
     * @return string the message.
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Getter for the request response as JSON.
     *
     * @param bool $assoc if the returned JSON should be formatted as an associative array or an stdClass instance.
     * @return array|stdClass
     */
    public function getJsonResult($assoc = false)
    {
        return json_decode($this->result, $assoc);
    }

    /**
     * Setter for the request response headers.
     *
     * @param array $headers the headers,
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * Returns the http request response code.
     *
     * @return int the http code or 0 if not set.
     */
    public function getCode()
    {
        $matches = array();
        if (isset($this->headers) && isset($this->headers[0])) {
            preg_match('|HTTP/\d\.\d\s+(\d+)\s+.*|', $this->headers[0], $matches);
        }
        return isset($matches[1]) ? (int)$matches[1] : 0;
    }

    /**
     * Returns the raw http request response status string.
     *
     * @return string the status string or empty if not set.
     */
    public function getRawStatus()
    {
        return (isset($this->headers) && isset($this->headers[0])) ? $this->headers[0] : '';
    }
}
