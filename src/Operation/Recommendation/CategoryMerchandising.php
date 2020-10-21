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

use Nosto\Types\Signup\AccountInterface;

class CategoryMerchandising extends AbstractRecommendation
{
    /** @var string $category */
    private $category;

    /** @var IncludeFilters */
    private $includeFilters;

    /** @var ExcludeFilters */
    private $excludeFilters;

    /** @var int */
    private $skipPages;

    /** @var string */
    private $batchToken;

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
     * @param string $batchToken
     */
    public function __construct(
        AccountInterface $account,
        $customerId,
        $category,
        $skipPages,
        IncludeFilters $includeFilters,
        ExcludeFilters $excludeFilters,
        $activeDomain = '',
        $customerBy = self::IDENTIFIER_BY_CID,
        $previewMode = false,
        $limit = self::DEFAULT_LIMIT,
        $batchToken = ''
    ) {
        $this->category = $category;
        $this->skipPages = $skipPages;
        $this->includeFilters = $includeFilters;
        $this->excludeFilters = $excludeFilters;
        $this->batchToken = $batchToken;
        parent::__construct($account, $customerId, $activeDomain, $customerBy, $previewMode, $limit);
    }

    /**
     * @inheritdoc
     */
    public function getQuery()
    {
        return <<<QUERY
            query(
                \$customerId: String!,
                \$category: String!,
                \$limit: Int!,
                \$preview: Boolean!,
                \$by: LookupParams!,
                \$skipPages: Int,
                \$includeFilters: InputIncludeParams,
                \$excludeFilters: InputFilterParams,
                \$batchToken: String
            ) {
              session (
                id: \$customerId,
                by: \$by,
              ) {
                id
                recos (preview: \$preview, image: VERSION_10_MAX_SQUARE) {
                  category (
                    category: \$category
                    minProducts: 1
                    maxProducts: \$limit,
                    skipPages: \$skipPages,
                    include: \$includeFilters,
                    exclude: \$excludeFilters,
                    skipVCEvent: true,
                    batchToken: \$batchToken
                  ) {
                    primary {
                      productId
                      priceText
                      name
                      imageUrl
                    }
                    batchToken
                    totalPrimaryCount
                    resultId
                  }
                }
              }
            }
QUERY;
    }

    /**
     * @inheritdoc
     */
    public function getVariables()
    {
        $variables = [
            'customerId' => $this->customerId,
            'category' => $this->category,
            'limit' => $this->limit,
            'preview' => $this->previewMode,
            'by' => $this->customerBy,
            'includeFilters' => $this->includeFilters->toArray(),
            'excludeFilters' => $this->excludeFilters->toArray()
        ];
        if ($this->batchToken !== '') {
            $variables['batchToken'] = $this->batchToken;
        } else {
            $variables['skipPages'] = $this->skipPages;
        }
        return $variables;
    }

    /**
     * @param string $batchToken
     */
    public function setBatchToken($batchToken)
    {
        $this->batchToken = $batchToken;
    }
}
