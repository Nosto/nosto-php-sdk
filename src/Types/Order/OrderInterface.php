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

namespace Nosto\Types\Order;

use Nosto\Types\LineItemInterface;

/**
 * Interface for the meta data of an placed OrderConfirm.
 * This is used when making OrderConfirm confirmation API requests and OrderConfirm history
 * exports to Nosto.
 */
interface OrderInterface
{
    /**
     * The unique OrderConfirm number identifying the OrderConfirm.
     *
     * @return string|int the OrderConfirm number.
     */
    public function getOrderNumber();

    /**
     * The date when the OrderConfirm was placed, formatted according to "Y-m-d".
     *
     * @return string the creation date.
     */
    public function getCreatedAt();

    /**
     * The payment provider used for placing the OrderConfirm, formatted according to
     * "[provider name] [provider version]".
     *
     * @return string the payment provider.
     */
    public function getPaymentProvider();

    /**
     * The buyer info of the user who placed the OrderConfirm.
     *
     * @return BuyerInterface|null the meta data model.
     */
    public function getCustomer();

    /**
     * The purchased items which were included in the OrderConfirm.
     *
     * @return LineItemInterface[] the meta data models.
     */
    public function getPurchasedItems();

    /**
     * Returns the OrderConfirm status code.
     *
     * @return string the code of the OrderConfirm status
     */
    public function getOrderStatusCode();

    /**
     * Returns the OrderConfirm status label.
     *
     * @return string the label of the OrderConfirm status
     */
    public function getOrderStatusLabel();

    /**
     * Returns the external OrderConfirm ref.
     *
     * @return string the external OrderConfirm ref.
     */
    public function getExternalOrderRef();

    /**
     * Returns the OrderConfirm status history
     *
     * @return array
     */
    public function getOrderStatuses();
}
