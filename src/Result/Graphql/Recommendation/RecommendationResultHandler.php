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

namespace Nosto\Result\Graphql\Recommendation;

use Nosto\Result\Graphql\GraphQLResultHandler;
use Nosto\Helper\ArrayHelper;
use Nosto\NostoException;

class RecommendationResultHandler extends GraphQLResultHandler
{
    const GRAPHQL_DATA_PRIMARY = 'primary';
    const GRAPHQL_DATA_CATEGORY = 'category';
    const GRAPHQL_DATA_RESULT_ID = 'resultId';
    const GRAPHQL_DATA_PRIMARY_COUNT = 'totalPrimaryCount';

    /**
     * @param \stdClass $stdClass
     * @throws NostoException
     * @return CategoryMerchandisingResult
     */
    protected function parseQueryResult(\stdClass $stdClass)
    {
        /** @var \stdClass $categoryData */
        $categoryData = self::parseData($stdClass, self::GRAPHQL_DATA_CATEGORY);
        /** @var string $trackingCode */
        $trackingCode = self::parseData($categoryData, self::GRAPHQL_DATA_RESULT_ID);
        /** @var int $totalPrimaryCount */
        $totalPrimaryCount = self::parseData($categoryData, self::GRAPHQL_DATA_PRIMARY_COUNT);
        /** @var ResultSet $resultSet */
        $resultSet = self::buildResultSet($categoryData);
        return new CategoryMerchandisingResult(
            $resultSet,
            $trackingCode,
            $totalPrimaryCount
        );
    }

    /**
     * @param \stdClass $stdClass
     * @return ResultSet
     * @throws NostoException
     */
    private static function buildResultSet(\stdClass $stdClass)
    {
        $primaryData = self::parseData($stdClass, self::GRAPHQL_DATA_PRIMARY);

        $resultSet = new ResultSet();
        foreach ($primaryData as $primaryDataItem) {
            if ($primaryDataItem instanceof \stdClass) {
                $primaryDataItem = ArrayHelper::stdClassToArray($primaryDataItem);
            }
            $item = new ResultItem($primaryDataItem);
            $resultSet->append($item);
        }
        return $resultSet;
    }

    /**
     * @param \stdClass $stdClass
     * @param string $dataType
     * @return string|int|\stdClass|array
     * @throws NostoException
     */
    private static function parseData(\stdClass $stdClass, $dataType)
    {
        $members = get_object_vars($stdClass);
        foreach ($members as $varName => $member) {
            if ($varName === $dataType) {
                return $member;
            }
            if ($member instanceof \stdClass) {
                return self::parseData($member, $dataType);
            }
        }
        throw new NostoException('Could not find field for ' . $dataType . ' data from response');
    }
}
