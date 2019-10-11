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

namespace Nosto\Operation\Recommendation;


class Filters
{
    private $brands = [];
    private $categories;
    private $customFields = [];
    private $discounted;
    private $fresh;
    private $price;
    private $productIds;
    private $rating;
    private $reviews;
    private $search;
    private $stock;
    private $tag1;
    private $tag2;
    private $tag3;

    /**
     * @param string $brands
     */
    public function setBrands($brands)
    {
        $this->brands[] = $brands;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @param string $attribute
     * @param array $customFields
     */
    public function setCustomFields($attribute, $customFields)
    {
        $this->customFields[] = [
            'attribute' => $attribute,
            'values' => $customFields
        ];
    }

    /**
     * @param mixed $discounted
     */
    public function setDiscounted($discounted)
    {
        $this->discounted = $discounted;
    }

    /**
     * @param mixed $fresh
     */
    public function setFresh($fresh)
    {
        $this->fresh = $fresh;
    }

    /**
     * @param int $min
     * @param int $max
     */
    public function setPrice($min, $max)
    {
        $this->price = ['min' => $min, 'max' => $max];
    }

    /**
     * @param mixed $productIds
     */
    public function setProductIds($productIds)
    {
        $this->productIds = $productIds;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @param mixed $reviews
     */
    public function setReviews($reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * @param mixed $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @param mixed $tag1
     */
    public function setTag1($tag1)
    {
        $this->tag1 = $tag1;
    }

    /**
     * @param mixed $tag2
     */
    public function setTag2($tag2)
    {
        $this->tag2 = $tag2;
    }

    /**
     * @param mixed $tag3
     */
    public function setTag3($tag3)
    {
        $this->tag3 = $tag3;
    }

    public function process()
    {

        $array = [];

        foreach ($this as $key => $value) {
            if ($value !== null) {
                $array = array_merge($array, [$key => $value]);
            }
        }
        return $array;
    }
}