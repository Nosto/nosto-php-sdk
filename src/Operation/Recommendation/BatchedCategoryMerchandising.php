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

namespace Nosto\Operation\Recommendation;

use Nosto\NostoException;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Request\Http\Exception\HttpResponseException;
use Nosto\Result\Graphql\Recommendation\CategoryMerchandisingResult;
use Nosto\Types\Signup\AccountInterface;
use Nosto\Util\Recommendation;

class BatchedCategoryMerchandising
{
    const HARD_LIMIT = 250;

    /** @var string $category */
    private $category;

    /** @var IncludeFilters */
    private $includeFilters;

    /** @var ExcludeFilters */
    private $excludeFilters;

    /** @var int */
    private $skipPages;

    /** @var AccountInterface */
    private $account;

    /** @var string */
    private $customerId;

    /** @var string */
    private $activeDomain;

    /** @var string */
    private $customerBy;

    /** @var bool */
    private $previewMode;

    /** @var int */
    private $limit;

    /**
     * CategoryMerchandising constructor.
     * @param AccountInterface $account
     * @param $customerId
     * @param $category
     * @param $skipPages
     * @param IncludeFilters $includeFilters
     * @param ExcludeFilters $excludeFilters
     * @param string $activeDomain
     * @param string $customerBy
     * @param bool $previewMode
     * @param int $limit
     */
    public function __construct(
        AccountInterface $account,
        $customerId,
        $category,
        $skipPages,
        IncludeFilters $includeFilters,
        ExcludeFilters $excludeFilters,
        $activeDomain = '',
        $customerBy = CategoryMerchandising::IDENTIFIER_BY_CID,
        $previewMode = false,
        $limit = CategoryMerchandising::DEFAULT_LIMIT
    ) {
        $this->category = $category;
        $this->skipPages = $skipPages;
        $this->includeFilters = $includeFilters;
        $this->excludeFilters = $excludeFilters;
        $this->account = $account;
        $this->customerId = $customerId;
        $this->activeDomain = $activeDomain;
        $this->customerBy = $customerBy;
        $this->previewMode = $previewMode;
        $this->limit = $limit;
    }

    /**
     * Splits category merchandising calls based on hard limit (250) and given limit
     *
     * @return CategoryMerchandisingResult
     * @throws AbstractHttpException
     * @throws HttpResponseException
     * @throws NostoException
     */
    public function execute()
    {
        $batchCount = 1;
        $limit = $this->limit;
        if ($this->limit >= self::HARD_LIMIT) {
            $batchCount = ceil($this->limit / self::HARD_LIMIT);
            $limit = self::HARD_LIMIT;
        }
        $responses = [];
        for ($x=0; $x < $batchCount; $x++) {
            $categoryMerchandising = new CategoryMerchandising(
                $this->account,
                $this->customerId,
                $this->category,
                $x,
                $this->includeFilters,
                $this->excludeFilters,
                $this->activeDomain,
                $this->customerBy,
                $this->previewMode,
                $limit
            );
            /** @var CategoryMerchandisingResult $response */
            $response = $categoryMerchandising->execute();
            $responses[] = $response;
            if ($response->getResultSet()->count() === 0) {
                break;
            }
        }

        return Recommendation::mergeCategoryMerchandisingResults($responses);
    }
}
