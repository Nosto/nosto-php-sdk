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

namespace Nosto;

use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Request\Http\HttpRequest;
use Nosto\Request\Http\HttpResponse;
use Nosto\Exception\Builder as ExceptionBuilder;

/**
 * Main SDK class.
 * Provides common functionality for the SDK.
 */
class Nosto
{
    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR = 'error';

    const CODE_ACCOUNT_CREATE = 'account_create';
    const CODE_ACCOUNT_CONNECT = 'account_connect';
    const CODE_ACCOUNT_DELETE = 'account_delete';
    const CODE_ACCOUNT_CONNECT_REJECT = 'account_connect_reject';

    const DEFAULT_NOSTO_SERVER_URL = 'connect.nosto.com';
    const DEFAULT_NOSTO_EMAIL_WIDGET_BASE_URL = 'https://connect.nosto.com';
    const DEFAULT_NOSTO_WEB_HOOK_BASE_URL = 'https://my.nosto.com';
    const DEFAULT_NOSTO_OAUTH_BASE_URL = 'https://my.nosto.com/oauth';
    const DEFAULT_NOSTO_API_BASE_URL = 'https://api.nosto.com';
    const DEFAULT_NOSTO_GRAPHQL_BASE_URL = 'https://api.nosto.com';
    const DEFAULT_NOSTO_IFRAME_ORIGIN_REGEXP = '(https:\/\/(.*)\.hub\.nosto\.com)|(https:\/\/my\.nosto\.com)'; //codingStandardsIgnoreLine

    const URL_PARAM_MESSAGE_TYPE = 'message_type';
    const URL_PARAM_MESSAGE_CODE = 'message_code';
    const URL_PARAM_MESSAGE_TEXT = 'message_text';

    /**
     * Return environment variable.
     *
     * @param string $name the name of the variable.
     * @param mixed|null $default the default value to return if the env variable cannot be found.
     * @return mixed the env variable or null.
     */
    public static function getEnvVariable($name, $default = null)
    {
        return getenv($name) ? getenv($name) : $default;
    }

    public static function getServerUrl()
    {
        return self::getEnvVariable('NOSTO_SERVER_URL', self::DEFAULT_NOSTO_SERVER_URL);
    }

    public static function getEmailWidgetBaseUrl()
    {
        return self::getEnvVariable('NOSTO_EMAIL_WIDGET_BASE_URL', self::DEFAULT_NOSTO_EMAIL_WIDGET_BASE_URL);
    }

    public static function getBaseUrl()
    {
        return self::getEnvVariable('NOSTO_WEB_HOOK_BASE_URL', self::DEFAULT_NOSTO_WEB_HOOK_BASE_URL);
    }

    public static function getOAuthBaseUrl()
    {
        return self::getEnvVariable('NOSTO_OAUTH_BASE_URL', self::DEFAULT_NOSTO_OAUTH_BASE_URL);
    }

    public static function getApiBaseUrl()
    {
        return self::getEnvVariable('NOSTO_API_BASE_URL', self::DEFAULT_NOSTO_API_BASE_URL);
    }

    public static function getGraphqlBaseUrl()
    {
        return self::getEnvVariable('NOSTO_GRAPHQL_BASE_URL', self::DEFAULT_NOSTO_GRAPHQL_BASE_URL);
    }

    public static function getIframeOriginRegex()
    {
        return self::getEnvVariable('NOSTO_IFRAME_ORIGIN_REGEXP', self::DEFAULT_NOSTO_IFRAME_ORIGIN_REGEXP);
    }

    /**
     * Throws a new HttpException exception with info about both the
     * request and response.
     *
     * @param HttpRequest $request the request object to take additional info from.
     * @param HttpResponse $response the response object to take additional info from.
     * @throws AbstractHttpException the exception.
     * @deprecated No longer used by internal code and not recommended.
     * Use \Exception\Builder::fromHttpRequestAndResponse() instead
     */
    public static function throwHttpException(
        HttpRequest $request,
        HttpResponse $response
    ) {
        throw ExceptionBuilder::fromHttpRequestAndResponse($request, $response);
    }
}
