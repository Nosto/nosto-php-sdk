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
 * Iframe helper class for account administration iframe.
 */
final class NostoHelperIframe extends NostoHelper
{
    const IFRAME_URI_INSTALL = '/hub/{platform}/install';
    const IFRAME_URI_UNINSTALL = '/hub/{platform}/uninstall';

    /**
     * Returns the url for the account administration iframe.
     * If the passed account is null, then the url will point to the start page where a new account can be created.
     *
     * @param NostoIframeInterface $iframe the iframe meta data.
     * @param NostoAccountInterface|null $account the configuration to return the url for.
     * @param NostoSignupOwnerInterface $user
     * @param array $params additional parameters to add to the iframe url.
     * @return string the iframe url.
     */
    public static function getUrl(
        NostoIframeInterface $iframe,
        NostoAccountInterface $account = null,
        NostoSignupOwnerInterface $user = null,
        array $params = array()
    ) {
        $defaultParameters = array(
            'lang' => strtolower($iframe->getLanguageIsoCode()),
            'ps_version' => $iframe->getVersionPlatform(),
            'nt_version' => $iframe->getVersionModule(),
            'product_pu' => $iframe->getPreviewUrlProduct(),
            'category_pu' => $iframe->getPreviewUrlCategory(),
            'search_pu' => $iframe->getPreviewUrlSearch(),
            'cart_pu' => $iframe->getPreviewUrlCart(),
            'front_pu' => $iframe->getPreviewUrlFront(),
            'shop_lang' => strtolower($iframe->getLanguageIsoCodeShop()),
            'shop_name' => $iframe->getShopName(),
            'unique_id' => $iframe->getUniqueId(),
            'fname' => $iframe->getFirstName(),
            'lname' => $iframe->getLastName(),
            'email' => $iframe->getEmail(),
        );
        if ($account instanceof NostoAccountInterface) {
            $missingScopes = $account->getMissingTokens();
            if (!empty($missingScopes)) {
                $defaultParameters['missing_scopes'] = implode(',', $missingScopes);
            }
        }
        $queryParams = http_build_query(
            array_merge(
                $defaultParameters,
                $params
            )
        );

        if ($account !== null && $user !== null && $account->isConnectedToNosto()) {
            try {
                $service = new NostoOperationSSO($account);
                $url = $service->get($user, $iframe->getPlatform()) . '?' . $queryParams;
            } catch (NostoException $e) {
                // If the SSO fails, we show a "remove account" page to the user in order to
                // allow to remove Nosto and start over.
                // The only case when this should happen is when the api token for some
                // reason is invalid, which is the case when switching between environments.
                $url = NostoHttpRequest::buildUri(
                    NostoHelperIframe::getBaseUrl() . self::IFRAME_URI_UNINSTALL . '?' . $queryParams,
                    array(
                        '{platform}' => $iframe->getPlatform(),
                    )
                );
            }
        } else {
            $url = NostoHttpRequest::buildUri(
                NostoHelperIframe::getBaseUrl() . self::IFRAME_URI_INSTALL . '?' . $queryParams,
                array(
                    '{platform}' => $iframe->getPlatform(),
                )
            );
        }

        return $url;
    }

    /**
     * Returns the base url for the Nosto iframe.
     *
     * @return string the url.
     */
    protected function getBaseUrl()
    {
        return Nosto::getEnvVariable('NOSTO_WEB_HOOK_BASE_URL', NostoHttpRequest::$baseUrl);
    }
}
