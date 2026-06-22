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

namespace Nosto\Operation;

use Nosto\Helper\SerializationHelper;
use Nosto\Model\Format;
use Nosto\Types\SettingsInterface;

class UpdateSettingsPayload
{
    private $title;
    private $languageCode;
    private $frontPageUrl;
    private $currencyCode;
    private $currencies;
    private $defaultVariantId;
    private $useExchangeRates;

    /**
     * @param SettingsInterface $settings
     */
    public function __construct(SettingsInterface $settings)
    {
        $this->title = $settings->getTitle();
        $this->languageCode = $settings->getLanguageCode();
        $this->frontPageUrl = $settings->getFrontPageUrl();
        $this->currencyCode = $settings->getCurrencyCode();
        $this->currencies = $this->buildCurrencies($settings);
        $this->defaultVariantId = $settings->getDefaultVariantId();
        $this->useExchangeRates = $settings->getUseExchangeRates();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLanguageCode()
    {
        return $this->languageCode;
    }

    public function getFrontPageUrl()
    {
        return $this->frontPageUrl;
    }

    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    public function getCurrencies()
    {
        return $this->currencies;
    }

    public function getDefaultVariantId()
    {
        return $this->defaultVariantId;
    }

    public function getUseExchangeRates()
    {
        return $this->useExchangeRates;
    }

    /**
     * @param SettingsInterface $settings
     * @return array|null
     */
    private function buildCurrencies(SettingsInterface $settings)
    {
        $currencies = $settings->getCurrencies();
        if (empty($currencies) || !is_array($currencies)) {
            return null;
        }

        $payload = [];
        foreach ($currencies as $code => $format) {
            if ($format instanceof Format) {
                $payload[$code] = $this->buildCurrency($format);
            }
        }

        return empty($payload) ? null : $payload;
    }

    /**
     * @param Format $format
     * @return array
     */
    private function buildCurrency(Format $format)
    {
        $data = [
            'currencyBeforeAmount' => $format->getCurrencyBeforeAmount(),
            'currencyToken' => $format->getCurrencyToken(),
            'decimalCharacter' => $format->getDecimalCharacter(),
            'groupingSeparator' => $format->getGroupingSeparator(),
            'decimalPlaces' => $format->getDecimalPlaces(),
        ];

        return array_filter($data, static function ($value) {
            return !SerializationHelper::isNull($value);
        });
    }
}
