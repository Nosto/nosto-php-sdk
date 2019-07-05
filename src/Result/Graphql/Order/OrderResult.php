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

namespace Nosto\Result\Graphql\Order;

use Nosto\NostoException;
use Nosto\Request\Http\HttpResponse;

class OrderResult
{
    const GRAPHQL_RESPONSE_ERROR = 'errors';
    const GRAPHQL_RESPONSE_SUCCESS = 'data';
    const GRAPHQL_RESPONSE_UPDATE_STATUS = 'updateStatus';
    const GRAPHQL_ORDER_ID = 'id';

    /**
     * @param HttpResponse $response
     * @return mixed|null
     * @throws NostoException
     */
    public static function parseResult(HttpResponse $response)
    {
        $result = json_decode($response->getResult());
        $members = get_object_vars($result);

        //Check for errors
        if (array_key_exists(self::GRAPHQL_RESPONSE_ERROR, $members)) {
            foreach ($members as $varName => $member)
            {
                if ($varName === self::GRAPHQL_RESPONSE_ERROR) {
                    self::parseErrorMessage($member);
                }
            }
            return null;
        }

        //Parse results
        foreach ($members as $varName => $member)
        {
            if ($varName === self::GRAPHQL_RESPONSE_SUCCESS) {
                return self::parseSuccessMessage($member);
            }
        }
        return null;
    }

    /**
     * @param array $errors
     * @throws NostoException
     */
    public static function parseErrorMessage(array $errors)
    {
        if (count($errors) > 0) {
            $message = $errors[0]->message;
            throw new NostoException($message);
        }
    }

    /**
     * @param \stdClass $stdClass
     * @return mixed
     */
    public static function parseSuccessMessage(\stdClass $stdClass)
    {
        $members = get_object_vars($stdClass);
        foreach ($members as $varName => $member) {
            if ($varName === self::GRAPHQL_ORDER_ID ||
                $varName === self::GRAPHQL_RESPONSE_UPDATE_STATUS) {
                return $member;
            }
            if ($member instanceof \stdClass) {
                return self::parseSuccessMessage($member);
            }
        }
    }
}