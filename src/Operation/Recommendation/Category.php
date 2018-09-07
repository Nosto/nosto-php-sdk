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

namespace Nosto\Operation\Recommendation;

use Nosto\Request\Api\ApiRequest;
use Nosto\Request\Grapql\GraphqlRequest;
use Nosto\Types\Signup\AccountInterface;
use Nosto\Request\Api\Token;

/**
 * Operation class for getting product ids in a category
 */
class Category extends AbstractRecommendationOperation
{
    private $category;
    private $customerId;
    private $limit;

    /**
     * Category constructor
     *
     * @param AccountInterface $account
     * @param string $category
     * @param string $customerId
     * @param int $limit
     */
    public function __construct(
        AccountInterface $account,
        $category,
        $customerId,
        $limit = 20
    ) {
        parent::__construct($account);
        $this->category = $category;
        $this->customerId = $customerId;
        $this->limit = $limit;
    }

    /**
     * @inheritdoc
     */
    public function getQuery()
    {
        $query
            = <<<QUERY
        {
            "query": "mutation(
                    \$customerId: String!,
                    \$category: String!,
                    \$limit: Int!,
                    \$preview: Boolean!
            ) { 
                updateSession(by: BY_CID, id: \$customerId, params: {
                    customer: {}
                    event: { 
                        type: VIEWED_CATEGORY
                        target: \$category
                    }     
                    cart: {}
                }) {
                    id,
                    recos (preview: \$preview, image: VERSION_8_400_400) {
                        category_ids: toplist(
                            hours: 168,
                            sort: VIEWS
                            params: {
                                minProducts: 1,
                                maxProducts: \$limit,
                                include: {
                                    categories: [\$category]
                                }
                            }
                        ) {
                            primary {
                                productId
                            }     
                        }
                    }
                }
            }",
            "variables": {
                "customerId": "%s",
                "category": "%s", 
                "limit": "%d",
                "preview": %s
            }
        }
QUERY;
        $formatted = sprintf(
            $query,
            $this->customerId,
            $this->category,
            $this->limit,
            $this->isPreviewMode(true)
        );

        return $formatted;
    }
}
