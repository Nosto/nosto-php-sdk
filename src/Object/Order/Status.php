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

namespace Nosto\Object\Order;

use Nosto\Object\AbstractObject;
use Nosto\Types\Order\StatusInterface;

/**
 * Model class containing information about the OrderConfirm status of an OrderConfirm
 */
class OrderStatus extends AbstractObject implements StatusInterface
{
    /**
     * @var string the OrderConfirm status code as flagged via the payment provider
     */
    private $code;

    /**
     * @var string the OrderConfirm status label as flagged via the payment provider
     */
    private $label;

    /**
     * @var string the OrderConfirm status date as set via the payment provider
     */
    private $date;

    /**
     * OrderStatus constructor
     */
    public function __construct()
    {
        // Dummy
    }

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the code of the OrderConfirm status as flagged by the payment provider.
     * The code is a normalised string i.e. lower-cased and underscored
     *
     * @param string $code the code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the label of the OrderConfirm status as flagged by the payment provider.
     * The label is the name of the OrderConfirm status for reporting purposes
     *
     * @param string $label the label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @inheritdoc
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date of the OrderConfirm status as flagged by the payment provider.
     * The date should be in the Y-m-d format.
     *
     * @param string $date the date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}
