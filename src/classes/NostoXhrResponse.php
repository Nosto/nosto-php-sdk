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
 * Util class for representing a XHR response object used when responding to
 * account administration iframe API calls.
 */
class NostoXhrResponse
{
    /**
     * @var string the `Content-Type` of the response.
     */
    public $contentType = 'application/json';

    /**
     * @var bool the response success flag.
     */
    protected $success = false;

    /**
     * @var string the response redirect url.
     */
    protected $redirectUrl;

    /**
     * Sets the response success state.
     *
     * @param boolean $success the state.
     * @return NostoXhrResponse the response instance.
     */
    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }

    /**
     * Sets the response redirect url.
     *
     * @param string $url the url.
     * @return NostoXhrResponse the response instance.
     */
    public function setRedirectUrl($url)
    {
        $this->redirectUrl = $url;
        return $this;
    }

    /**
     * Sends the response, i.e. sends it to the browser.
     * This method also sends the `Content-Type` header for the response data.
     */
    public function send()
    {
        header('Content-Type: '.$this->contentType);
        echo $this;
    }

    /**
     * Converts the response to a string and returns it.
     *
     * @return string the string representation of the response.
     */
    public function __toString()
    {
        return (string)json_encode(array(
            'success' => (bool)$this->success,
            'redirect_url' => (string)$this->redirectUrl,
        ));
    }
}
