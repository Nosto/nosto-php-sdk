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
 * Handles exchanging the authorization token for the API tokes from Nosto
 */
class NostoOperationOauthSync extends NostoOperation
{
    /**
     * @var NostoOAuthClientMetaDataInterface the Oauth meta data params
     */
    private $meta;

    /**
     * Constructor.
     *
     * Accepts the Nosto account for which the service is to operate on.
     *
     * @param NostoOAuthClientMetaDataInterface $meta the oauth meta data params
     */
    public function __construct(NostoOAuthClientMetaDataInterface $meta)
    {
        $this->meta = $meta;
    }

    /**
     * Sends a POST request to delete an account for a store in Nosto
     *
     * @param $code string the oauth access code.
     * @return NostoAccountInterface the configured account
     * @throws NostoException on failure.
     */
    public function exchange($code)
    {
        $oauthClient = new NostoOAuthClient($this->meta);
        $oauthResponse = $oauthClient->authenticate($code);

        $request = new NostoHttpRequest();
        $request->setContentType('application/x-www-form-urlencoded');
        $request->setPath(NostoHttpRequest::PATH_OAUTH_SYNC);
        $request->setQueryParams(array('access_token' => $oauthResponse->getAccessToken()));
        $response = $request->get();
        if ($response->getCode() !== 200) {
            Nosto::throwHttpException('Failed to sync account from Nosto..', $request, $response);
        }

        $tokens = NostoApiToken::parseTokens($response->getJsonResult(true), 'api_');
        $account = new NostoAccount($oauthResponse->getMerchantName());
        $account->setTokens($tokens);
        return $account;
    }
}
