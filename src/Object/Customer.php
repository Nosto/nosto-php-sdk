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

namespace Nosto\Object;

use Nosto\Types\CustomerInterface;
use Nosto\Types\MarkupableInterface;

/**
 * Customer object for tagging
 */
class Customer extends User implements CustomerInterface, MarkupableInterface
{
    /**
     * @var string customer reference
     */
    private $customerReference;

    /**
     * @var string visitor checksum
     */
    private $hcid;

    /**
     * @var string customer group
     */
    private $customerGroup;

    /**
     * @var Subscription subscription
     */
    private $subscription;

    /**
     * Get the visitor checksum
     *
     * @return string
     */
    public function getHcid()
    {
        return $this->hcid;
    }

    /**
     * Set the visitor checksum
     *
     * @param string $hcid
     */
    public function setHcid($hcid)
    {
        $this->hcid = $hcid;
    }

    /**
     * @return string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }

    /**
     * @param string $customerReference
     */
    public function setCustomerReference($customerReference)
    {
        $this->customerReference = $customerReference;
    }

    public function getMarkupKey()
    {
        return 'nosto_customer';
    }

    /**
     * @return null|string
     */
    public function getCustomerGroup()
    {
        return $this->customerGroup;
    }

    /**
     * @param string $customerGroup
     */
    public function setCustomerGroup($customerGroup)
    {
        $this->customerGroup = $customerGroup;
    }

    /**
     * @return Subscription
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param string $name
     * @param \DateTime $startDate
     * @throws \Nosto\NostoException
     */
    public function setSubscription($name, $startDate)
    {
        $subscription = new Subscription();
        $subscription->setName($name);
        $subscription->setStartDate($startDate);
        $this->subscription = $subscription;
    }
}
