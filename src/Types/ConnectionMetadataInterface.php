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

namespace Nosto\Types;

/**
 * Interface for the meta data needed for the account configuration controls.
 */
interface ConnectionMetadataInterface
{
    /**
     * The name of the platform the connection is used on.
     * A list of valid platform names is issued by Nosto.
     *
     * @return string the platform name.
     */
    public function getPlatform();

    /**
     * The first name of the user who is loading the connection view.
     *
     * @return string the first name.
     */
    public function getFirstName();

    /**
     * The last name of the user who is loading the connection view.
     *
     * @return string the last name.
     */
    public function getLastName();

    /**
     * The email address of the user who is loading the connection view.
     *
     * @return string the email address.
     */
    public function getEmail();

    /**
     * The 2-letter ISO code (ISO 639-1) for the language of the user who is setting up the account.
     *
     * @return string the language ISO code.
     */
    public function getLanguageIsoCode();

    /**
     * The 2-letter ISO code (ISO 639-1) for the language of the shop the account belongs to.
     *
     * @return string the language ISO code.
     */
    public function getLanguageIsoCodeShop();

    /**
     * The version number of the platform the e-commerce installation is running on.
     *
     * @return string the platform version.
     */
    public function getVersionPlatform();

    /**
     * The version number of the Nosto module/extension running on the e-commerce installation.
     *
     * @return string the module version.
     */
    public function getVersionModule();

    /**
     * Returns the name of the shop context where Nosto is installed or about to be installed in.
     *
     * @return string the name.
     */
    public function getShopName();

    /**
     * Returns associative array with installed modules.
     *
     * @return array array(moduleName=1, moduleName=0)
     */
    public function getModules();
}
