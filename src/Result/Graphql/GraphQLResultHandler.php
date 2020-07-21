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

namespace Nosto\Result\Graphql;

use Nosto\NostoException;
use Nosto\Request\Http\HttpResponse;
use Nosto\Result\ResultHandler;

abstract class GraphQLResultHandler extends ResultHandler
{
    const GRAPHQL_RESPONSE_ERROR = 'errors';
    const GRAPHQL_RESPONSE_DATA = 'data';

    /**
     * @inheritdoc
     */
    protected function parseResponse(HttpResponse $response)
    {
        $result = json_decode($response->getResult());

        if ($this->hasErrors($result)) {
            $error = $this->parseErrorMessage($result->errors);
            throw new NostoException($error);
        }

        if ($this->hasData($result)) {
            return $this->parseQueryResult($result->data);
        }

        throw new NostoException('No data found in GraphQL result');
    }

    /**
     * @param \stdClass $stdClass
     * @return bool
     */
    private function hasErrors(\stdClass $stdClass)
    {
        $members = get_object_vars($stdClass);
        if (array_key_exists(self::GRAPHQL_RESPONSE_ERROR, $members)) {
            return true;
        }
        return false;
    }

    /**
     * @param \stdClass $stdClass
     * @return bool
     */
    private function hasData(\stdClass $stdClass)
    {
        $members = get_object_vars($stdClass);
        if (array_key_exists(self::GRAPHQL_RESPONSE_DATA, $members)) {
            return true;
        }
        return false;
    }

    /**
     * @param array $errors
     * @return string
     */
    private function parseErrorMessage(array $errors)
    {
        $errorMessage = '';
        foreach ($errors as $error) {
            $errorMessage .= $error->message.' | ';
        }
        return $errorMessage;
    }

    /**
     * @param \stdClass $stdClass
     * @throws NostoException
     * @return mixed
     */
    abstract protected function parseQueryResult(\stdClass $stdClass);
}
