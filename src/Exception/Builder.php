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

namespace Nosto\Exception;

use Nosto\Request\Api\Exception\ApiResponseException;
use Nosto\Request\Http\Exception\HttpResponseException;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Request\Http\HttpRequest;
use Nosto\Request\Http\HttpResponse;

class Builder
{

    /**
     * Return HttpException exception with info about both the
     * request and response.
     *
     * @param HttpRequest $request
     * @param HttpResponse $response
     * @return AbstractHttpException|HttpResponseException
     */
    public static function fromHttpRequestAndResponse(
        HttpRequest $request,
        HttpResponse $response
    ) {
        $message = '';
        $jsonResponse = $response->getJsonResult();

        $errors = self::parseErrorsFromResponse($response);
        if (isset($jsonResponse->type, $jsonResponse->message)) {
            $message .= $jsonResponse->message;
            if (!empty($errors)) {
                $message .= ' | ' . $errors;
            }
            return new ApiResponseException(
                $message,
                $response->getCode(),
                null,
                $request,
                $response
            );
        }

        if ($response->getMessage()) {
            $message .= $response->getMessage();
        }
        if (!empty($errors)) {
            $message .= ' | ' . $errors;
        }
        return new HttpResponseException(
            $message,
            $response->getCode(),
            null,
            $request,
            $response
        );
    }

    /**
     * Parses errors from HttpResponse
     * @param HttpResponse $response
     * @return string
     */
    public static function parseErrorsFromResponse(HttpResponse $response)
    {
        $json = $response->getJsonResult();
        $errorStr = '';
        if (isset($json->errors)
            && is_array($json->errors)
            && !empty($json->errors)
        ) {
            foreach ($json->errors as $stdClassError) {
                if (isset($stdClassError->errors)) {
                    $errorStr .= $stdClassError->errors;
                }
                if (isset($stdClassError->product_id)) {
                    $errorStr .= sprintf('(product #%s)', $stdClassError->product_id);
                }
            }
        }

        return $errorStr;
    }
}
