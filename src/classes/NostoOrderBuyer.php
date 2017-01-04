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
 * Model for order buyer information. This is used when compiling the info about
 * an order that is sent to Nosto.
 */
class NostoOrderBuyer extends NostoObject implements NostoOrderBuyerInterface
{
    /**
     * @var string the first name of the user who placed the order.
     */
    protected $_firstName;

    /**
     * @var string the last name of the user who placed the order.
     */
    protected $_lastName;

    /**
     * @var string the email address of the user who placed the order.
     */
    protected $_email;

    /**
     * @inheritdoc
     */
    public function getFirstName()
    {
        return $this->_firstName;
    }

    /**
     * Sets the firstname of the buyer.
     *
     * The name must be a non-empty string.
     *
     * Usage:
     * $object->setFirstName('John');
     *
     * @param string $firstName the firstname.
     *
     * @return $this Self for chaining
     */
    public function setFirstName($firstName)
    {
        $this->_firstName = $firstName;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLastName()
    {
        return $this->_lastName;
    }

    /**
     * Sets the lastname of the buyer.
     *
     * The name must be a non-empty string.
     *
     * Usage:
     * $object->setLastName('Doe');
     *
     * @param string $lastName the lastname.
     *
     * @return $this Self for chaining
     */
    public function setLastName($lastName)
    {
        $this->_lastName = $lastName;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Sets the email of the buyer.
     *
     * The email must be a non-empty string.
     *
     * Usage:
     * $object->setEmail('john@doe.com');
     *
     * @param string $email the email.
     *
     * @return $this Self for chaining
     */
    public function setEmail($email)
    {
        $this->_email = $email;

        return $this;
    }
}
