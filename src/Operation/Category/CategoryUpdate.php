<?php
/**
 * Copyright (c) 2023, Nosto Solutions Ltd
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

namespace Nosto\Operation\Category;

use Nosto\Result\Graphql\Category\CategoryUpdateResultHandler;
use Nosto\Types\CategoryInterface;
use Nosto\Operation\AbstractGraphQLOperation;
use Nosto\Types\Signup\AccountInterface;
use Nosto\Helper\SerializationHelper;

/**
 * Operation class for updating categories
 * @phan-file-suppress PhanUnreferencedUseNormal
 */
class CategoryUpdate extends AbstractGraphQLOperation
{

    /** @var CategoryInterface */
    private $category;

    /**
     * OrderCreate constructor.
     * @param CategoryInterface $category
     * @param AccountInterface $account
     * @param string $activeDomain
     */
    public function __construct(
        CategoryInterface $category,
        AccountInterface $account,
        $activeDomain = ''
    ) {
        $this->category = $category;
        parent::__construct($account, $activeDomain);
    }

    /**
     * @inheritdoc
     */
    public function getCategories()
    {
        return [
            [
                'available' => (boolean) $this->category->isAvailable(),
                'id' => (string) $this->category->getId(),
                'name' => $this->category->getTitle(),
                'parentId' => (string) $this->category->getParentId(),
                'urlPath' => $this->category->getPath(),
                'url' => $this->category->getCategoryUrl()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function getResultHandler()
    {
        return new CategoryUpdateResultHandler();
    }


    /**
     * @return string
     */
    public function getQuery()
    {
        return <<<QUERY
            mutation(
                \$categories:[InputVendorCategoryEntity]!
            ){
                 upsertCategories(categories: \$categories)
                 {
                    categoryResult {
                        category {
                          id
                        }
                     }
                 }
            }
QUERY;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return [
            'categories' => $this->getCategories()
        ];
    }
}
