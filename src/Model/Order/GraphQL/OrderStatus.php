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

namespace Nosto\Model\Order\GraphQL;

use Nosto\AbstractObject;
use Nosto\Mixins\HtmlEncoderTrait;
use Nosto\Types\HtmlEncodableInterface;

class OrderStatus extends AbstractObject implements
    HtmlEncodableInterface
{
    use HtmlEncoderTrait;

    /** @var string */
    private $orderNumber;

    /** @var string */
    private $status;

    /** @var string */
    private $paymentProvider;

    /** @var string */
    private $updatedAt;

    /**
     * OrderStatus constructor.
     * @param string $orderNumber
     * @param string $status
     * @param string $paymentProvider
     * @param string $updatedAt
     */
    public function __construct(
        $orderNumber,
        $status,
        $paymentProvider,
        $updatedAt
    ) {
        $this->orderNumber = $orderNumber;
        $this->status = $status;
        $this->paymentProvider = $paymentProvider;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getPaymentProvider()
    {
        return $this->paymentProvider;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        $date = new \DateTime($this->updatedAt);
        return $date->format('Y-m-d\TH:i:s');
    }
}
