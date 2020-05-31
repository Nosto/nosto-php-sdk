<?php /** @noinspection Annotator */

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

namespace Nosto\Mixins;

use Nosto\Helper\IframeHelper;
use Nosto\Nosto;
use Nosto\NostoException;
use Nosto\Operation\InitiateSso;
use Nosto\Request\Http\HttpRequest;
use Nosto\Types\IframeInterface;
use Nosto\Types\Signup\AccountInterface;
use Nosto\Types\UserInterface;

/**
 * Iframe mixin class for account administration iframe.
 */
trait IframeTrait
{
    /**
     * Returns the url for the account administration iframe.
     * If the passed account is null, then the url will point to the start page where a new account can be created.
     *
     * @param array $params additional parameters to add to the iframe url.
     * @return string the iframe url.
     */
    public function buildURL(array $params = [])
    {
        $iframe = self::getIframe();
        $defaultParameters = IframeHelper::getDefaultParams($iframe);

        $account = self::getAccount();
        if ($account instanceof AccountInterface) {
            $missingScopes = $account->getMissingTokens();
            if (!empty($missingScopes)) {
                $defaultParameters['missing_scopes'] = implode(',', $missingScopes);
            }
        }
        $queryParams = http_build_query(array_merge($defaultParameters, $params));

        $user = self::getUser();
        if ($account !== null && $user !== null && $account->isConnectedToNosto()) {
            try {
                $service = new InitiateSso($account);
                $url = $service->get($user, $iframe->getPlatform()) . '?' . $queryParams;
            } catch (NostoException $e) {
                // If the SSO fails, we show a "remove account" page to the user in OrderConfirm to
                // allow to remove Nosto and start over.
                // The only case when this should happen is when the api token for some
                // reason is invalid, which is the case when switching between environments.
                $errorParams = [
                    Nosto::URL_PARAM_MESSAGE_TYPE => Nosto::TYPE_ERROR,
                    Nosto::URL_PARAM_MESSAGE_CODE => Nosto::CODE_ACCOUNT_DELETE,
                    Nosto::URL_PARAM_MESSAGE_TEXT => $e->getMessage()
                ];
                $queryParams = http_build_query(array_merge($defaultParameters, $params, $errorParams));
                $url = HttpRequest::buildUri(
                    Nosto::getBaseUrl() . '/hub/{platform}/uninstall' . '?' . $queryParams,
                    ['{platform}' => $iframe->getPlatform(),]
                );
            }
        } else {
            $url = HttpRequest::buildUri(
                Nosto::getBaseUrl() . '/hub/{platform}/install' . '?' . $queryParams,
                ['{platform}' => $iframe->getPlatform()]
            );
        }

        return $url;
    }
    /**
     * Returns the iframe params with which to load the IFrame
     *
     * @return IframeInterface the iframe params with which to load the iframe
     */
    abstract public function getIframe();

    /**
     * Returns the current for which to load the IFrame
     *
     * @return UserInterface the current user for which to load the iframe
     */
    abstract public function getUser();

    /**
     * Returns the account for which to load the IFrame
     *
     * @return AccountInterface the account for which to load the iframe
     */
    abstract public function getAccount();
}
