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

namespace Nosto\Object\Product;

use Nosto\Mixins\CollectionJsonSerializerTrait;
use Nosto\Object\AbstractCollection;
use Nosto\Types\JsonDenormalizableInterface;
use Nosto\Types\MarkupableInterface;
use Nosto\Types\Product\SkuInterface;
use Nosto\Types\SanitizableInterface;

/**
 * Collection class to store a collection of SKUs
 */
class SkuCollection extends AbstractCollection implements
    MarkupableInterface,
    SanitizableInterface,
    JsonDenormalizableInterface
{
    use CollectionJsonSerializerTrait;

    /**
     * Appends item to the collection of skus
     *
     * @param SkuInterface $sku the product to append
     */
    public function append(SkuInterface $sku)
    {
        $this->var[] = $sku;
    }

    public function getMarkupKey()
    {
        return 'skus';
    }

    /**
     * Sanitizes SKUs in the collection
     * @return SkuCollection
     */
    public function sanitize()
    {
        $sanitized = new self();
        /* @var $item SkuInterface */
        foreach ($this as $item) {
            $sanitized->append($item->sanitize());
        }
        return $sanitized;
    }

    /**
     * @inheritDoc
     */
    public function deserializeType()
    {
        return Sku::class;
    }
}

