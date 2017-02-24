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

namespace Nosto\Helper;

use Nosto\Request\Http\HttpRequest;
use Nosto\Types\OAuthInterface;

/**
 * OAuth helper class for working with common OAuth related functionality
 */
class OAuthHelper extends AbstractHelper
{

    const PATH_AUTH = '?client_id={cid}&redirect_uri={uri}&response_type=code&scope={sco}&lang={iso}'; // @codingStandardsIgnoreLine

    /**
     * Returns the authorize url to the oauth2 server.
     *
     * @param OAuthInterface $params
     * @return string the url.
     */
    public static function getAuthorizationUrl(OAuthInterface $params)
    {
        return HttpRequest::buildUri(
            getenv('NOSTO_OAUTH_BASE_URL') . self::PATH_AUTH,
            array(
                '{cid}' => $params->getClientId(),
                '{uri}' => urlencode($params->getRedirectUrl()),
                '{sco}' => implode(' ', $params->getScopes()),
                '{iso}' => strtolower($params->getLanguageIsoCode()),
            )
        );
    }
}