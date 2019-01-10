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

namespace Nosto\Object\Email;

/**
 * ImageUrl object for formatting email widget image url
 */
class ImageUrl
{
    const NOSTO_ACCOUNT_PLACEHOLDER = '@NOSTO_ACCOUNT@';
    const EMAIL_PLACEHOLDER = '@EMAIL@';
    const CAMPAIGN_ID_PLACEHOLDER = '@CAMPAIGN_ID@';
    const URL_TEMPLATE = 'url_template';
    const CUSTOMER_EMAIL = 'customer_email';
    const CAMPAIGN_ID = 'campaign_id';

    /**
     * @var string $urlTemplate
     */
    private $urlTemplate;
    /**
     * @var string $nostoAccount nosto account id
     */
    private $nostoAccount;
    /**
     * @var string $customerEmail customer email address
     */
    private $customerEmail;
    /**
     * @var string $campaignId
     */
    private $campaignId;

    /**
     * ImageUrl constructor.
     * @param string $urlTemplate
     * @param string $nostoAccount
     * @param string $customerEmail
     * @param string $campaignId
     */
    public function __construct($urlTemplate, $nostoAccount, $customerEmail, $campaignId)
    {
        $this->urlTemplate = $urlTemplate;
        $this->nostoAccount = $nostoAccount;
        $this->customerEmail = $customerEmail;
        $this->campaignId = $campaignId;
    }

    /**
     * @return string
     */
    public function getUrlTemplate()
    {
        return $this->urlTemplate;
    }

    /**
     * @param string $urlTemplate
     */
    public function setUrlTemplate($urlTemplate)
    {
        $this->urlTemplate = $urlTemplate;
    }

    /**
     * @return string
     */
    public function getNostoAccount()
    {
        return $this->nostoAccount;
    }

    /**
     * @param string $nostoAccount
     */
    public function setNostoAccount($nostoAccount)
    {
        $this->nostoAccount = $nostoAccount;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return string
     */
    public function getCampaignId()
    {
        return $this->campaignId;
    }

    /**
     * @param string $campaignId
     */
    public function setCampaignId($campaignId)
    {
        $this->campaignId = $campaignId;
    }

    /**
     * @return string
     */
    public function format()
    {
        $src = str_replace(self::NOSTO_ACCOUNT_PLACEHOLDER, $this->nostoAccount, $this->urlTemplate);
        $src = str_replace(self::EMAIL_PLACEHOLDER, $this->customerEmail, $src);
        $src = str_replace(self::CAMPAIGN_ID_PLACEHOLDER, $this->campaignId, $src);

        return $src;
    }
}
