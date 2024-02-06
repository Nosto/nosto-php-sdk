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

namespace Nosto\Util;

use Nosto\Request\Http\HttpResponse;
use Nosto\Operation\AbstractOperation;
use Nosto\Request\Http\Exception\HttpResponseException as ResponseException;
use stdClass;

class HttpResponseException
{
    /**
     * @param HttpResponse $httpResponse
     * @throws ResponseException
     */
    public static function handle(HttpResponse $httpResponse)
    {
        if (strpos($httpResponse->getContentType(), AbstractOperation::CONTENT_TYPE_APPLICATION_JSON) !== false) {
            self::handleJson($httpResponse);
        } else {
            self::handlePlainText($httpResponse);
        }
    }

    /**
     * @param HttpResponse $httpResponse
     * @throws ResponseException
     */
    private static function handlePlainText(HttpResponse $httpResponse) {
        throw new ResponseException(
            sprintf(
                'Something went wrong:  %s %s',
                $httpResponse->getMessage() ?? 'Received empty response from Nosto\'s API',
                self::getXRequestId($httpResponse)
            ),
            $httpResponse->getCode()
        );
    }

    /**
     * @param HttpResponse $httpResponse
     * @throws ResponseException
     */
    private static function handleJson(HttpResponse $httpResponse)
    {

        $message = '';
        $result = $httpResponse->getJsonResult();

        if (isset($result->message)) {
            $message .= $result->message;
        }

        if (isset($result->errors) && is_array($result->errors)) {
            foreach ($result->errors as $error) {
                if ($error instanceof stdClass) {
                    $message .= self::getErrorsFromStdClass($error);
                }
            }
        }
        $message .= self::getXRequestId($httpResponse);
        throw new ResponseException($message);
    }

    /**
     * @param HttpResponse $httpResponse
     * @return string|null
     */
    private static function getXRequestId(HttpResponse $httpResponse)
    {
        if ($httpResponse != null) {
            return sprintf("{Nosto request id is: %s}: ", $httpResponse->getXRequestId());
        }

        return null;
    }

    /**
     * @param stdClass $errors
     * @return string
     */
    private static function getErrorsFromStdClass(stdClass $errors)
    {
        $errors = get_object_vars($errors);
        $errorString = '';
        foreach ($errors as $key => $error) {
            $errorString .= ' | ' . $key . ': ' . $error;
        }
        return $errorString;
    }
}
