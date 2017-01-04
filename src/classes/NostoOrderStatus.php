<?php
/**
 * Copyright (c) 2016, Nosto Solutions Ltd
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
 * @copyright 2016 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

/**
 * Model for order status information. This is used when compiling the info
 * about an order that is sent to Nosto.
 */
class NostoOrderStatus extends NostoObject implements NostoOrderStatusInterface
{
    /**
     * @var string the order status code.
     */
    protected $code;

    /**
     * @var string the order status label.
     */
    protected $label;

    /**
     * @inheritdoc
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the order status code.
     *
     * The code must be a non-empty string.
     *
     * Usage:
     * $object->setCode('completed');
     *
     * @param string $code the code.
     *
     * @return $this Self for chaining
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the label of the order.
     *
     * The label must be a non-empty string.
     *
     * Usage:
     * $object->setLabel('Completed');
     *
     * @param string $label the label.
     *
     * @return $this Self for chaining
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Converts a human readable status description to a machine readable code,
     * i.e. converts the description to a lower case alphanumeric string.
     *
     * @param string $description the description to convert.
     * @return string the status code.
     */
    protected function convertDescriptionToCode($description)
    {
        $pattern = array('/[^a-zA-Z0-9]+/', '/_+/', '/^_+/', '/_+$/');
        $replacement = array('_', '_', '', '');
        return strtolower(preg_replace($pattern, $replacement, $description));
    }
}
