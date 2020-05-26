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

namespace Nosto\Model;

use Nosto\Types\MarkupableInterface;
use Nosto\Types\MarkupableCollectionInterface;

/**
 * Collection class to store a collection of products
 */
class StringCollection extends AbstractCollection implements MarkupableCollectionInterface, MarkupableInterface
{
    /** @var string|null */
    private $markupKey;
    /** @var string|null */
    private $childMarkupKey;

    /**
     * StringCollection constructor.
     * @param string $markupKey
     * @param string $childMarkupKey
     * @param array $initArray array of string
     */
    public function __construct($markupKey, $childMarkupKey, $initArray = null)
    {
        $this->childMarkupKey = $childMarkupKey;
        $this->markupKey = $markupKey;

        if ($initArray) {
            foreach ($initArray as $item) {
                $this->var[] = $item;
            }
        }
    }

    /**
     * @param $item
     */
    public function append($item)
    {
        $this->var[] = $item;
    }

    /**
     * @return null|string
     */
    public function getMarkupKey()
    {
        return $this->markupKey;
    }

    /**
     * @return null|string
     */
    public function getChildMarkupKey()
    {
        return $this->childMarkupKey;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->var;
    }

    /**
     * Set the data
     * @param array $data It should be an array with string items
     */
    public function setData($data)
    {
        if ($data === null) {
            $this->var = [];
        } else {
            $this->var = $data;
        }
    }
}
