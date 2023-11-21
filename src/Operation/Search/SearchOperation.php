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
    private string $accountId;

    private string $query = '';

    private ?string $categoryId = null;

    private int $size = 20;

    private int $from = 0;

    private array $sort = [];

    private array $filters = [];

    private ?array $sessionParams = null;

    public function setAccountId(string $accountId): void
    {
        $this->accountId = $accountId;
    }

    public function setQuery(string $query): void
    {
        $this->query = $query;
    }

    public function setCategoryId(string $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function setSort(string $field, string $order): void
    {
        $this->sort = [
            "field" => $field,
            "order" => strtolower($order),
        ];
    }

    public function setFrom(int $from): void
    {
        $this->from = $from;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function addValueFilter(string $filterField, string $value): void
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

    public function addRangeFilter(string $filterField, ?string $min = null, ?string $max = null): void
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
                $range,
            );
        } else {
            $this->filters[$filterField] = [
                'field' => $filterField,
                'range' => $range,
            ];
        }
    }

    public function setSessionParams(array $sessionParams): void
    {
        $this->sessionParams = $sessionParams;
    }

    public function getQuery()
    {
        return <<<GRAPHQL
        query(
            \$accountId: String,
            \$query: String,
            \$categoryId: String,
            \$sort: [InputSearchSort!],
            \$filter: [InputSearchTopLevelFilter!],
            \$sessionParams: InputSearchQuery,
            \$size: Int,
            \$from: Int,
        ) {
            search(
                accountId: \$accountId,
                query: \$query,
                products: {
                    categoryId: \$categoryId,
                    sort: \$sort,
                    filter: \$filter,
                    size: \$size,
                    from: \$from,
                },
                sessionParams: \$sessionParams,
            ) {
                redirect,
                products {
                    total,
                    hits {
                        productId
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

    public function getVariables(): array
    {
        return [
            'accountId' => $this->accountId,
            'query' => $this->query,
            'categoryId' => $this->categoryId,
            'sort' => $this->sort,
            'size' => $this->size,
            'from' => $this->from,
            'filter' => array_values($this->filters),
            'sessionParams' => $this->sessionParams,
        ];
    }
}