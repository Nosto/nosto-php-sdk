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

namespace Nosto\Operation;

use Nosto\NostoException;
use Nosto\Request\Api\Token;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Request\Http\HttpRequest;
use Nosto\Result\Api\GeneralPurposeResultHandler;
use Nosto\Types\Signup\AccountInterface;

class SendVersionInfo extends AbstractAuthenticatedOperation
{
    /**
     * TODO: Replace with real endpoint when available.
     */
    const MOCK_ENDPOINT_URL = 'https://mock.nosto.com/sdk/version';

    /**
     * @var string the platform name (e.g., "Shopware")
     */
    private $platform;

    /**
     * @var string the platform version (e.g., "6.6.9")
     */
    private $platformVersion;

    /**
     * @var string the plugin version (e.g., "5.1.6")
     */
    private $pluginVersion;

    /**
     * SendVersionInfo constructor.
     *
     * @param AccountInterface $account the account object
     * @param string $platform the platform name
     * @param string $platformVersion the platform version
     * @param string $pluginVersion the plugin version
     * @param string $activeDomain the active domain
     */
    public function __construct(
        AccountInterface $account,
        $platform,
        $platformVersion,
        $pluginVersion,
        $activeDomain = ''
    ) {
        parent::__construct($account, $activeDomain);
        $this->platform = $platform;
        $this->platformVersion = $platformVersion;
        $this->pluginVersion = $pluginVersion;
    }

    /**
     * Sends version information to Nosto API.
     * This method prepares and sends a JSON payload with platform and plugin version information.
     *
     * @return bool true if the request was successful
     * @throws NostoException on API communication failure
     * @throws AbstractHttpException on HTTP errors
     */
    public function sendVersionInfo()
    {
        try {
            $request = $this->initRequest(
                $this->account->getApiToken(Token::API_PRODUCTS),
                $this->account->getName(),
                $this->activeDomain
            );

            // Set custom URL for mock endpoint (remove this line when real endpoint is available)
            $request->setUrl(self::MOCK_ENDPOINT_URL);

            $versionData = $this->buildVersionPayload();
            $response = $request->postRaw(json_encode($versionData));

            return $request->getResultHandler()->parse($response);
        } catch (NostoException $e) {
            // Re-throw Nosto-specific exceptions
            throw $e;
        } catch (AbstractHttpException $e) {
            // Re-throw HTTP-specific exceptions
            throw $e;
        }
    }

    /**
     * Builds the version information payload.
     *
     * @return array the version information payload
     */
    private function buildVersionPayload()
    {
        return [
            'platform' => $this->platform,
            'platformVersion' => $this->platformVersion,
            'pluginVersion' => $this->pluginVersion
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getResultHandler()
    {
        return new GeneralPurposeResultHandler();
    }

    /**
     * @inheritdoc
     */
    protected function getRequestType()
    {
        return new HttpRequest();
    }

    /**
     * @inheritdoc
     */
    protected function getContentType()
    {
        return self::CONTENT_TYPE_APPLICATION_JSON;
    }

    /**
     * @inheritdoc
     */
    protected function getPath()
    {
        // This will be overridden by the mock URL until the real endpoint is available
        return '/sdk/version';
    }
}