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

namespace Nosto\Result\Graphql;


use Nosto\Helper\SerializationHelper;
use Nosto\NostoException;
use Nosto\Operation\Recommendation\AbstractOperation;
use Nosto\Request\Http\HttpResponse;

class ResultSetBuilder
{
    /**
     * Builds a result set from HttpResponse
     *
     * @param HttpResponse $httpResponse
     * @return ResultSet
     * @throws NostoException
     */
    public static function fromHttpResponse(HttpResponse $httpResponse)
    {
        $result = json_decode($httpResponse->getResult());

        $primaryData = self::parsePrimaryData($result);

        $resultSet = new ResultSet();
        foreach ($primaryData as $primaryDataItem) {
            if ($primaryDataItem instanceof \stdClass) {
                $primaryDataItem = SerializationHelper::stdClassToArray($primaryDataItem);
            }
            $item = new ResultItem($primaryDataItem);
            $resultSet->append($item);
        }
        return $resultSet;
    }

    /**
     * Finds the primary data field from stdClass
     *
     * @param \stdClass $class
     * @return mixed
     * @throws NostoException
     */
    public static function parsePrimaryData(\stdClass $class)
    {
        $members = get_object_vars($class);
        foreach ($members as $varName => $member) {
            if ($varName == AbstractOperation::GRAPHQL_DATA_KEY) {
                return $member;
            } elseif ($member instanceof \stdClass) {
                return self::parsePrimaryData($member);
            }
        }

        throw new NostoException(
            sprintf(
                'Could not find primary data field (%s) from response',
                AbstractOperation::GRAPHQL_DATA_KEY
            )
        );
    }
}