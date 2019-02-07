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

namespace Nosto\Object;

use Nosto\AbstractObject;
use Nosto\Types\PersonInterface;

/**
 * Abstract model used for containing the basic details of person for purposes
 * such as representing a customer or a logged-in user.
 */
abstract class AbstractPerson extends AbstractObject implements PersonInterface
{
    /**
     * @var string the first name of the person
     */
    private $firstName;

    /**
     * @var string the last name of the person
     */
    private $lastName;

    /**
     * @var string the email address of the person
     */
    private $email;

    /**
     * @var string the phone number of the person
     */
    private $phone;

    /**
     * @var string the post code of the person
     */
    private $postCode;

    /**
     * @var string the country of the person
     */
    private $country;

    /**
     * @var boolean the opt-in status for the person
     */
    private $marketingPermission;

    /**
     * @var string gender
     */
    private $gender;

    /**
     * @var string date of birth
     */
    private $dateOfBirth;

    /**
     * @var string the region of the person
     */
    private $region;

    /**
     * @var string the city of the person
     */
    private $city;

    /**
     * @var string the street of the person
     */
    private $street;

    public function __construct()
    {
        $this->setMarketingPermission(false);
    }

    /**
     * The first name of the person
     *
     * @return string the first name.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the first name of the person
     *
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * The last name of the person
     *
     * @return string the last name.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets the last name of the person
     *
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * The email address of the person.
     *
     * @return string the email address.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email address of the person
     *
     * @param string $email the email address.
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param string|null $postCode
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;
    }

    /**
     * @return string|null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return bool
     */
    public function getMarketingPermission()
    {
        return $this->marketingPermission;
    }

    /**
     * @param bool $marketingPermission
     */
    public function setMarketingPermission($marketingPermission)
    {
        $this->marketingPermission = (bool)$marketingPermission;
    }

    /**
     * @param bool $optedIn
     * @deprecated will be removed in near future, use setMarketingPermission instead
     */
    public function setOptedIn($optedIn)
    {
        $this->setMarketingPermission($optedIn);
    }

    /**
     * @return null|string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string|null
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime|\DateTimeInterface|string $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        if ($dateOfBirth instanceof \DateTime
            || (is_object($dateOfBirth) && method_exists($dateOfBirth, 'format'))) {
            $this->dateOfBirth = $dateOfBirth->format('Y-m-d');
        } else {
            $this->dateOfBirth = $dateOfBirth;
        }
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return null|string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return null|string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return null|string
     */
    public function getStreet()
    {
        return $this->street;
    }
}
