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

use Nosto\NostoException;
use Nosto\Types\Signup\AccountInterface;

class Builder
{
    /** @var AccountInterface $accountInterface */
    private $nostoAccount;

    /** @var string $customerId */
    private $customerId;

    /** @var string $category */
    private $category;

    /** @var string $customerBy */
    private $customerBy = CategoryMerchandising::IDENTIFIER_BY_CID;

    /** @var int $limit */
    private $limit = CategoryMerchandising::LIMIT;

    /** @var string $activeDomain */
    private $activeDomain = '';

    /** @var bool $previewMode */
    private $previewMode = false;

    /**
     * @return CategoryMerchandising
     * @throws NostoException
     */
    public function build()
    {
        if (!$this->nostoAccount instanceof AccountInterface) {
            throw new NostoException('Variable nostoAccount should be instance of AccountInterface');
        }
        if (is_string($this->customerId) && $this->customerId === '') {
            throw new NostoException('Variable customerId should be a non empty string');
        }
        if (is_string($this->category) && $this->category === '') {
            throw new NostoException('Variable category should be a non empty string');
        }
        return new CategoryMerchandising(
            $this->nostoAccount,
            $this->customerId,
            $this->category,
            $this->activeDomain,
            $this->customerBy,
            $this->limit,
            $this->previewMode
        );
    }

    /**
     * @param bool $previewMode
     */
    public function setPreviewMode($previewMode)
    {
        $this->previewMode = $previewMode;
    }

    /**
     * @param string $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @param string $customerBy
     */
    public function setCustomerBy($customerBy)
    {
        $this->customerBy = $customerBy;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param AccountInterface $nostoAccount
     */
    public function setNostoAccount($nostoAccount)
    {
        $this->nostoAccount = $nostoAccount;
    }

    /**
     * @param string $activeDomain
     */
    public function setActiveDomain($activeDomain)
    {
        $this->activeDomain = $activeDomain;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}
