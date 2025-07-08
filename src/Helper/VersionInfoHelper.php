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

namespace Nosto\Helper;

use Nosto\NostoException;
use Nosto\Operation\SendVersionInfo;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Types\Signup\AccountInterface;

class VersionInfoHelper
{
    /**
     * Sends version information to Nosto API.
     *
     * @param AccountInterface $account the Nosto account
     * @param string $platform the platform name (e.g., "Shopware")
     * @param string $platformVersion the platform version (e.g., "6.6.9")
     * @param string $pluginVersion the plugin version (e.g., "5.1.6")
     * @param mixed $logger optional logger instance for Shopware logging
     * @param string $activeDomain optional active domain
     * @return bool true if the request was successful
     * @throws NostoException on API communication failure
     * @throws AbstractHttpException on HTTP errors
     */
    public static function sendVersionInfo(
        AccountInterface $account,
        $platform,
        $platformVersion,
        $pluginVersion,
        $logger = null,
        $activeDomain = ''
    ) {
        try {
            $operation = new SendVersionInfo(
                $account,
                $platform,
                $platformVersion,
                $pluginVersion,
                $activeDomain
            );

            $result = $operation->sendVersionInfo();
 
            if ($logger && method_exists($logger, 'info')) {
                $logger->info('Successfully sent version info to Nosto', [
                    'platform' => $platform,
                    'platformVersion' => $platformVersion,
                    'pluginVersion' => $pluginVersion
                ]);
            }

            return $result;
        } catch (NostoException $e) { 
            if ($logger && method_exists($logger, 'error')) {
                $logger->error('Nosto API error sending version info: ' . $e->getMessage(), [
                    'platform' => $platform,
                    'platformVersion' => $platformVersion,
                    'pluginVersion' => $pluginVersion,
                    'error' => $e->getMessage()
                ]);
            }
            throw $e;
        } catch (AbstractHttpException $e) { 
            if ($logger && method_exists($logger, 'error')) {
                $logger->error('HTTP error sending version info to Nosto: ' . $e->getMessage(), [
                    'platform' => $platform,
                    'platformVersion' => $platformVersion,
                    'pluginVersion' => $pluginVersion,
                    'error' => $e->getMessage()
                ]);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($logger && method_exists($logger, 'error')) {
                $logger->error('Failed to send version info to Nosto: ' . $e->getMessage(), [
                    'platform' => $platform,
                    'platformVersion' => $platformVersion,
                    'pluginVersion' => $pluginVersion,
                    'error' => $e->getMessage()
                ]);
            }
            throw $e;
        }
    }
}