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

namespace Nosto\Result\Graphql\Recommendation;

class CategoryMerchandisingResult
{
    const DISPATCH_EVENT_NAME_POST_RESULTS = 'nosto_post_cmp_results';
    const DISPATCH_EVENT_NAME_PRE_RESULTS = 'nosto_pre_cmp_results';
    const DISPATCH_EVENT_KEY_REQUEST = 'categoryMerchandising';
    const DISPATCH_EVENT_KEY_RESULT = 'result';
    const DISPATCH_EVENT_KEY_LIMIT = 'limit';
    const DISPATCH_EVENT_KEY_PAGE = 'page';

    /** @var ResultSet $resultSet */
    private $resultSet;

    /** @var string $trackingCode */
    private $trackingCode;

    /** @var int $totalPrimaryCount */
    private $totalPrimaryCount;

    /** @var string $batchToken */
    private $batchToken;

    /**
     * CategoryMerchandisingResult constructor.
     * @param ResultSet $resultSet
     * @param string $trackingCode
     * @param int $totalPrimaryCount
     * @param string $batchToken
     */
    public function __construct(
        ResultSet $resultSet,
        $trackingCode,
        $totalPrimaryCount,
        $batchToken
    ) {
        $this->resultSet = $resultSet;
        $this->trackingCode = $trackingCode;
        $this->totalPrimaryCount = $totalPrimaryCount;
        $this->batchToken = $batchToken;
    }

    /**
     * @return ResultSet
     */
    public function getResultSet()
    {
        return $this->resultSet;
    }

    /**
     * @return string
     */
    public function getTrackingCode()
    {
        return $this->trackingCode;
    }

    /**
     * @return int
     */
    public function getTotalPrimaryCount()
    {
        return $this->totalPrimaryCount;
    }

    /**
     * @return string
     */
    public function getBatchToken()
    {
        return $this->batchToken;
    }

    /**
     * @param CategoryMerchandisingResult $result
     * @return array
     */
    public static function parseProductIds(CategoryMerchandisingResult $result)
    {
        $productIds = [];
        foreach ($result->getResultSet() as $item) {
            if ($item->getProductId() && is_numeric($item->getProductId())) {
                $productIds[] = $item->getProductId();
            }
        }
        return $productIds;
    }
}
