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

namespace Nosto\Result;

use Nosto\NostoException;
use Nosto\Operation\AbstractOperation;
use Nosto\Request\Http\HttpResponse;
use Nosto\Request\Http\Exception\HttpResponseException;
use Nosto\Result\Graphql\Recommendation\ResultSet;

abstract class ResultHandler
{

    /**
     * @param HttpResponse $response
     * @return string|array|ResultSet|bool
     * @throws HttpResponseException
     * @throws NostoException
     */
    public function render(HttpResponse $response)
    {
        if ($response->getCode() !== 200) {
            $this->handleHttpException($response);
        }

        return $this->parseResponse($response);
    }

    /**
     * @param HttpResponse $response
     * @throws NostoException
     * @return string|bool
     */
    abstract protected function parseResponse(HttpResponse $response);


    /**
     * @param HttpResponse $response
     * @throws HttpResponseException
     */
    private function handleHttpException(HttpResponse $response)
    {
        $message = 'Something went wrong';
        if ($response->getContentType() === AbstractOperation::CONTENT_TYPE_APPLICATION_JSON) {
            $message = $this->parseErrorMessage($response);
        }
        throw new HttpResponseException($message, $response->getCode());
    }

    /**
     * @param HttpResponse $response
     * @return string
     */
    private function parseErrorMessage(HttpResponse $response)
    {
        $message = $response->getJsonResult()->message;

        $errorStr = '';
        if (isset($message->errors) && is_array($message->errors)) {
            foreach ($message->errors as $stdClassError) {
                if (isset($stdClassError->errors)) {
                    $errorStr .= $stdClassError->errors;
                }
                if (isset($stdClassError->product_id)) {
                    $errorStr .= sprintf('(product #%s)', $stdClassError->product_id);
                }
            }
        }
        return $message .' | '.$errorStr;
    }

}
