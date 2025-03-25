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

namespace Nosto\Operation\Search;

use Nosto\Operation\AbstractSearchOperation;
use Nosto\Result\Graphql\Search\SearchResultHandler;

class SearchOperation extends AbstractSearchOperation
{
    /** @var string */
    private $accountId;

    /** @var string */
    private $query = '';

    /** @var ?string */
    private $categoryId = null;

    /** @var ?string */
    private $categoryPath = null;

    /** @var ?string */
    private $variationId = null;

    /** @var int */
    private $size = 20;

    /** @var int */
    private $from = 0;

    /** @var ?array */
    private $sort = null;

    /** @var array */
    private $filters = [];

    /** @var ?array */
    private $sessionParams = null;

    /** @var bool */
    private $explain = false;

    /** @var ?string */
    private $redirect = null;

    /** @var ?float  */
    private $time = null;

    /** @var ?array */
    private $rules = null;

    /** @var ?array */
    private $customRules = null;

    /** @var ?array */
    private $segments = null;

    /** @var ?array */
    private $keywords = null;

    /**
     * @param string $accountId
     * @return void
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    }

    /**
     * @param string $query
     * @return void
     */
    public function setQuery($query)
    {
        $this->query = $query;
    }

    /**
     * @param string $categoryId
     * @return void
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @param string $categoryPath
     * @return void
     */
    public function setCategoryPath($categoryPath)
    {
        $this->categoryPath = $categoryPath;
    }

    /**
     * @param string $variationId
     * @return void
     */
    public function setVariationId($variationId)
    {
        $this->variationId = $variationId;
    }

    /**
     * @param string $field
     * @param string $order
     * @return void
     */
    public function setSort($field, $order)
    {
        $this->sort = [
            "field" => $field,
            "order" => strtolower($order),
        ];
    }

    /**
     * @param int $from
     * @return void
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @param int $size
     * @return void
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param string $filterField
     * @param string $value
     * @return void
     */
    public function addValueFilter($filterField, $value)
    {
        if (array_key_exists($filterField, $this->filters)) {
            $this->filters[$filterField]['value'][] = $value;
        } else {
            $this->filters[$filterField] = [
                'field' => $filterField,
                'value' => [$value],
            ];
        }
    }

    /**
     * @param string $filterField
     * @param ?string $min
     * @param ?string $max
     * @return void
     */
    public function addRangeFilter($filterField, $min = null, $max = null)
    {
        $range = [];

        if (!is_null($min)) {
            $range['gt'] = $min;
        }
        if (!is_null($max)) {
            $range['lt'] = $max;
        }

        if (array_key_exists($filterField, $this->filters)) {
            $this->filters[$filterField]['range'] = array_merge(
                $this->filters[$filterField]['range'],
                $range
            );
        } else {
            $this->filters[$filterField] = [
                'field' => $filterField,
                'range' => $range,
            ];
        }
    }

    /**
     * @param array $sessionParams
     * @return void
     */
    public function setSessionParams($sessionParams)
    {
        $this->sessionParams = $sessionParams;
    }

    /**
     * @param bool $explain
     * @return void
     */
    public function setExplain($explain)
    {
        $this->explain = $explain;
    }

    /**
     * @param string $redirect
     * @return void
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @param float $time
     * @return void
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @param array $rules
     * @return void
     */
    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    /**
     * @param array $customRules
     * @return void
     */
    public function setCustomRules(array $customRules)
    {
        $this->customRules = $customRules;
    }

    /**
     * @param array $segments
     * @return void
     */
    public function setSegments(array $segments)
    {
        $this->segments = $segments;
    }

    /**
     * @param array $keywords
     * @return void
     */
    public function setKeywords(array $keywords)
    {
        $this->keywords = $keywords;
    }

    public function getQuery()
    {
        return <<<GRAPHQL
        query(
            \$accountId: String,
            \$query: String,
            \$categoryId: String,
            \$categoryPath: String,
            \$variationId: String,
            \$sort: [InputSearchSort!],
            \$filter: [InputSearchTopLevelFilter!],
            \$sessionParams: InputSearchQuery,
            \$size: Int,
            \$from: Int,
            \$redirect: String,
            \$explain: Boolean,
            \$time: Float,
            \$rules: [String!],
            \$customRules: [InputSearchRule!],
            \$segments: [String!],
            \$keywords: InputSearchKeywords,
        ) {
            search(
                accountId: \$accountId,
                query: \$query,
                products: {
                    categoryId: \$categoryId,
                    categoryPath: \$categoryPath,
                    variationId: \$variationId,
                    sort: \$sort,
                    filter: \$filter,
                    size: \$size,
                    from: \$from,
                },
                sessionParams: \$sessionParams,
                redirect: \$redirect,
                explain: \$explain,
                time: \$time,
                rules: \$rules,
                customRules: \$customRules,
                segments: \$segments,
                keywords: \$keywords,
            ) {
                redirect,
                products {
                    total,
                    hits {
                        productId
                        name,
                        customFields {
                          key,
                          value
                        }
                    }
                    facets {
                        ... on SearchStatsFacet {
                            id,
                            name
                            field,
                            type,
                            min,
                            max
                        }
                        ... on SearchTermsFacet {
                            id,
                            name
                            field,
                            type,
                            data {
                                value,
                                count,
                                selected,
                            }
                        }
                    }
                }
            }
        }
GRAPHQL;
    }

    protected function getResultHandler()
    {
        return new SearchResultHandler();
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return [
            'accountId' => $this->accountId,
            'query' => ($this->query == '' && ($this->categoryPath || $this->categoryId)) ?  null : $this->query ,
            'categoryId' => $this->categoryId,
            'categoryPath' => $this->categoryPath,
            'variationId' => $this->variationId,
            'sort' => $this->sort,
            'size' => $this->size,
            'from' => $this->from,
            'filter' => array_values($this->filters),
            'sessionParams' => $this->sessionParams,
            'explain' => $this->explain,
            'redirect' => $this->redirect,
            'time' => $this->time,
            'rules' => $this->rules,
            'customRules' => $this->customRules,
            'segments' => $this->segments,
            'keywords' => $this->keywords,
        ];
    }
}
