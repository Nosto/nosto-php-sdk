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

class NostoAccountMetaData implements NostoAccountMetaDataInterface
{
	protected $owner;
	protected $billing;
	public function __construct()
	{
		$this->owner = new NostoAccountMetaDataOwner();
		$this->billing = new NostoAccountMetaDataBilling();
	}
	public function getTitle()
	{
		return 'My Shop';
	}
	public function getName()
	{
		return '00000000';
	}
	public function getPlatform()
	{
		return 'platform';
	}
	public function getFrontPageUrl()
	{
		return 'http://localhost';
	}
	public function getCurrencyCode()
	{
		return 'USD';
	}
	public function getLanguageCode()
	{
		return 'en';
	}
	public function getOwnerLanguageCode()
	{
		return 'en';
	}
	public function getOwner()
	{
		return $this->owner;
	}
	public function getBillingDetails()
	{
		return $this->billing;
	}
	public function getSignUpApiToken()
	{
		return 'abc123';
	}

	public function getPartnerCode()
	{
		return '';
	}

	public function getCurrencies()
	{
		return array();
	}

	public function getUseCurrencyExchangeRates()
	{
		return array();
	}

	public function getDefaultVariationId()
	{
		return null;
	}

	public function getDetails()
	{
		return null;
	}
}
