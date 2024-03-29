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

namespace Nosto\Model;

use Nosto\AbstractObject;
use Nosto\Types\ConnectionMetadataInterface;

/**
 * Meta data class which holds information to be sent to the Nosto account
 * configuration view.
 */
class ConnectionMetadata extends AbstractObject implements ConnectionMetadataInterface
{
    /**
     * @var string the name of the platform the connection is used on.
     */
    private $platform;
    /**
     * @var string the admin user first name.
     */
    private $firstName;
    /**
     * @var string the admin user last name.
     */
    private $lastName;
    /**
     * @var    string the admin user email address.
     */
    private $email;
    /**
     * @var string the language ISO (ISO 639-1) code for oauth server locale.
     */
    private $languageIsoCode;
    /**
     * @var string the language ISO (ISO 639-1) for the store view scope.
     */
    private $languageIsoCodeShop;
    /**
     * @var string the name of the store Nosto is installed in or about to be installed.
     */
    private $shopName;
    /**
     * @var string the version number of the module extension is running on.
     */
    private $versionModule;
    /**
     * @var string the version number of the platform extension is running on.
     */
    private $versionPlatform;
    /**
     * @var array the associative array with installed modules
     */
    private $modules = [];

    public function __construct()
    {
        // Dummy
    }

    /**
     * The name of the platform the connection is used on.
     * A list of valid platform names is issued by Nosto.
     *
     * @return string the platform name.
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * The first name of the user who is loading the connection view.
     *
     * @return string the first name.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * The last name of the user who is loading the connection view.
     *
     * @return string the last name.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * The email address of the user who is loading the connection view.
     *
     * @return string the email address.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * The 2-letter ISO code (ISO 639-1) for the language of the user who is
     * loading the connection view.
     *
     * @return string the language ISO code.
     */
    public function getLanguageIsoCode()
    {
        return $this->languageIsoCode;
    }

    /**
     * @param string $languageIsoCode
     */
    public function setLanguageIsoCode($languageIsoCode)
    {
        $this->languageIsoCode = $languageIsoCode;
    }

    /**
     * The 2-letter ISO code (ISO 639-1) for the language of the shop the
     * account belongs to.
     *
     * @return string the language ISO code.
     */
    public function getLanguageIsoCodeShop()
    {
        return $this->languageIsoCodeShop;
    }

    /**
     * @param string $languageIsoCodeShop
     */
    public function setLanguageIsoCodeShop($languageIsoCodeShop)
    {
        $this->languageIsoCodeShop = $languageIsoCodeShop;
    }

    /**
     * The version number of the platform the e-commerce installation is
     * running on.
     *
     * @return string the platform version.
     */
    public function getVersionPlatform()
    {
        return $this->versionPlatform;
    }

    /**
     * @param string $versionPlatform
     */
    public function setVersionPlatform($versionPlatform)
    {
        $this->versionPlatform = $versionPlatform;
    }

    /**
     * The version number of the Nosto module/extension running on the
     * e-commerce installation.
     *
     * @return string the module version.
     */
    public function getVersionModule()
    {
        return $this->versionModule;
    }

    /**
     * @param string $versionModule
     */
    public function setVersionModule($versionModule)
    {
        $this->versionModule = $versionModule;
    }

    /**
     * Returns the name of the shop context where Nosto is installed or about to be installed in.
     *
     * @return string the name.
     */
    public function getShopName()
    {
        return $this->shopName;
    }

    /**
     * @param string $shopName
     */
    public function setShopName($shopName)
    {
        $this->shopName = $shopName;
    }

    /**
     * Add an installed module to the list of installed modules.
     *
     * @param $module array the installed modules
     */
    public function addModule(array $module)
    {
        $this->modules[] = $module;
    }

    /**
     * @inheritdoc
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Sets the associative array with installed modules.
     *
     * @param array $modules the array of installed modules
     */
    public function setModules(array $modules)
    {
        $this->modules = $modules;
    }
}
