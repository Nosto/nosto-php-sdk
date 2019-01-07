<?php
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

use Exception;
use Nosto\Nosto;
use Nosto\NostoException;
use Nosto\Operation\OAuth\AuthorizationCode;
use Nosto\Operation\OAuth\ExchangeTokens;
use Nosto\Types\Signup\AccountInterface;

trait OauthTrait
{

    public final function connect()
    {
        if (($code = self::getParam('code')) !== null) {
            try {
                $meta = self::getMeta();

                $operation = new AuthorizationCode($meta);
                $token = $operation->authenticate($code);

                $operation = new ExchangeTokens($meta);
                $account = $operation->exchange($token);

                if (self::save($account)) {
                    self::redirect(
                        array(
                            Nosto::URL_PARAM_MESSAGE_TYPE => Nosto::TYPE_SUCCESS,
                            Nosto::URL_PARAM_MESSAGE_CODE => Nosto::CODE_ACCOUNT_CONNECT
                        )
                    );
                    return;
                } else {
                    throw new NostoException('Failed to connect account');
                }
            } catch (NostoException $e) {
                self::logError($e);
                self::redirect(
                    array(
                        Nosto::URL_PARAM_MESSAGE_TYPE => Nosto::TYPE_ERROR,
                        Nosto::URL_PARAM_MESSAGE_CODE => Nosto::CODE_ACCOUNT_CONNECT,
                        Nosto::URL_PARAM_MESSAGE_TEXT => $e->getMessage()
                    )
                );
                return;
            }
        } elseif (($error = self::getParam('error')) !== null) {
            $logMsg = $error;
            if (($reason = self::getParam('error_reason')) !== null) {
                $logMsg .= ' - ' . $reason;
            }
            if (($desc = self::getParam('error_description')) !== null) {
                $logMsg .= ' - ' . $desc;
            }
            self::logError(new Exception($logMsg));
            self::redirect(
                array(
                    Nosto::URL_PARAM_MESSAGE_TYPE => Nosto::TYPE_ERROR,
                    Nosto::URL_PARAM_MESSAGE_CODE => Nosto::CODE_ACCOUNT_CONNECT,
                    Nosto::URL_PARAM_MESSAGE_TEXT => $desc
                )
            );
        } else {
            self::notFound();
        }
    }

    public abstract function getParam($name);

    public abstract function getMeta();

    public abstract function save(AccountInterface $account);

    public abstract function redirect(array $params);

    public abstract function logError(Exception $e);

    public abstract function notFound();
}
