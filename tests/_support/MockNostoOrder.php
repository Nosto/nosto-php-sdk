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

class MockNostoOrder implements NostoOrderInterface, NostoValidatableInterface
{
    public function getOrderNumber()
    {
        return 1;
    }

    public function getCreatedDate()
    {
        return '2014-12-12';
    }

    public function getPaymentProvider()
    {
        return 'test-gateway [1.0.0]';
    }

    public function getBuyerInfo()
    {
        return new MockNostoOrderBuyer();
    }

    public function getPurchasedItems()
    {
        return array(new MockNostoLineItem());
    }

    public function getOrderStatus()
    {
        return new MockNostoOrderStatus();
    }

    public function getValidationRules()
    {
        return array();
    }

    public function getExternalOrderRef()
    {
        return 'ext ref';
    }

    public function getArray()
    {
        $data = array(
            'order_number' => $this->getOrderNumber(),
            'external_order_ref' => $this->getExternalOrderRef(),
            'buyer' => array(),
            'created_at' => NostoHelperDate::format($this->getCreatedDate()),
            'payment_provider' => $this->getPaymentProvider(),
            'purchased_items' => array(),
        );
        if ($this->getOrderStatus()) {
            $data['order_status_code'] = $this->getOrderStatus()->getCode();
            $data['order_status_label'] = $this->getOrderStatus()->getLabel();
        }
        foreach ($this->getPurchasedItems() as $item) {
            $data['purchased_items'][] = array(
                'product_id' => $item->getProductId(),
                'quantity' => $item->getQuantity(),
                'name' => $item->getName(),
                'unit_price' => NostoHelperPrice::format($item->getUnitPrice()),
                'price_currency_code' => strtoupper($item->getCurrencyCode()),
            );
        }
        if ($this->getBuyerInfo()) {
            if ($this->getBuyerInfo()->getFirstName()) {
                $data['buyer']['first_name'] = $this->getBuyerInfo()->getFirstName();
            }
            if ($this->getBuyerInfo()->getLastName()) {
                $data['buyer']['last_name'] = $this->getBuyerInfo()->getLastName();
            }
            if ($this->getBuyerInfo()->getEmail()) {
                $data['buyer']['email'] = $this->getBuyerInfo()->getEmail();
            }
        }
        
        return $data;
    }

}
