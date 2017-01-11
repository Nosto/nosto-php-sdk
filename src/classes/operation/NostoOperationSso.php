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

/**
 * Handles getting a single sign-on token from the Nosto API.
 */
class NostoOperationSso extends NostoOperation
{
    /**
     * @var NostoAccountInterface Nosto configuration
     */
    private $account;

    /**
     * Constructor.
     *
     * Accepts the Nosto account for which the service is to operate on.
     *
     * @param NostoAccountInterface $account the Nosto configuration object.
     */
    public function __construct(NostoAccountInterface $account)
    {
        $this->account = $account;
    }

    /**
     * Sends a POST request to get a single signon URL for a store
     *
     * @param NostoCurrentUserInterface $user
     * @param $platform
     * @return string the sso URL if the request was successful.
     */
    public function get(NostoCurrentUserInterface $user, $platform)
    {
        $request = $this->initHttpRequest($this->account->getApiToken(NostoApiToken::API_SSO));
        $request->setPath(NostoApiRequest::PATH_SSO_AUTH);
        $request->setReplaceParams(array('{platform}' => $platform));
        $response = $request->post($user);
        if ($response->getCode() !== 200) {
            Nosto::throwHttpException($request, $response);
        }

        return $response->getJsonResult()->login_url;
    }
}
