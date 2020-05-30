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

namespace Nosto\Helper;

use Nosto\NostoException;

/**
 * Static data object with currency related info.
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @codeCoverageIgnore
 */
final class CurrencyHelper extends AbstractHelper
{
    /**
     * @var array currency data keyed on the currencies ISO 4217 codes.
     */
    private static $data = [
        'AED' => [
            'name' => 'UAE Dirham',
            'numericCode' => 784,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'AFN' => [
            'name' => 'Afghani',
            'numericCode' => 971,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ALL' => [
            'name' => 'Lek',
            'numericCode' => 8,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'AMD' => [
            'name' => 'Armenian Dram',
            'numericCode' => 51,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ANG' => [
            'name' => 'Netherlands Antillean Guilder',
            'numericCode' => 532,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'AOA' => [
            'name' => 'Kwanza',
            'numericCode' => 973,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ARS' => [
            'name' => 'Argentine Peso',
            'numericCode' => 32,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'AUD' => [
            'name' => 'Australian Dollar',
            'numericCode' => 36,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'AWG' => [
            'name' => 'Aruban Florin',
            'numericCode' => 533,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'AZN' => [
            'name' => 'Azerbaijanian Manat',
            'numericCode' => 944,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BAM' => [
            'name' => 'Convertible Mark',
            'numericCode' => 977,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BBD' => [
            'name' => 'Barbados Dollar',
            'numericCode' => 52,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BDT' => [
            'name' => 'Taka',
            'numericCode' => 50,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BGN' => [
            'name' => 'Bulgarian Lev',
            'numericCode' => 975,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BHD' => [
            'name' => 'Bahraini Dinar',
            'numericCode' => 48,
            'fractionDecimals' => 3,
            'fractionUnit' => 1000,
        ],
        'BIF' => [
            'name' => 'Burundi Franc',
            'numericCode' => 108,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'BMD' => [
            'name' => 'Bermudian Dollar',
            'numericCode' => 60,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BND' => [
            'name' => 'Brunei Dollar',
            'numericCode' => 96,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BOB' => [
            'name' => 'Boliviano',
            'numericCode' => 68,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BOV' => [
            'name' => 'Mvdol',
            'numericCode' => 984,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BRL' => [
            'name' => 'Brazilian Real',
            'numericCode' => 986,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BSD' => [
            'name' => 'Bahamian Dollar',
            'numericCode' => 44,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BTN' => [
            'name' => 'Ngultrum',
            'numericCode' => 64,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BTC' => [
            'name' => 'Bitcoin',
            'numericCode' => 00,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BWP' => [
            'name' => 'Pula',
            'numericCode' => 72,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'BYR' => [
            'name' => 'Belarussian Ruble',
            'numericCode' => 974,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'BZD' => [
            'name' => 'Belize Dollar',
            'numericCode' => 84,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CAD' => [
            'name' => 'Canadian Dollar',
            'numericCode' => 124,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CDF' => [
            'name' => 'Congolese Franc',
            'numericCode' => 976,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CHE' => [
            'name' => 'WIR Euro',
            'numericCode' => 947,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CHF' => [
            'name' => 'Swiss Franc',
            'numericCode' => 756,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CHW' => [
            'name' => 'WIR Franc',
            'numericCode' => 948,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CLF' => [
            'name' => 'Unidades de fomento',
            'numericCode' => 990,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'CLP' => [
            'name' => 'Chilean Peso',
            'numericCode' => 152,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'CNY' => [
            'name' => 'Yuan Renminbi',
            'numericCode' => 156,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'COP' => [
            'name' => 'Colombian Peso',
            'numericCode' => 170,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'COU' => [
            'name' => 'Unidad de Valor Real',
            'numericCode' => 970,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CRC' => [
            'name' => 'Costa Rican Colon',
            'numericCode' => 188,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CUC' => [
            'name' => 'Peso Convertible',
            'numericCode' => 931,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CUP' => [
            'name' => 'Cuban Peso',
            'numericCode' => 192,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CVE' => [
            'name' => 'Cape Verde Escudo',
            'numericCode' => 132,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'CZK' => [
            'name' => 'Czech Koruna',
            'numericCode' => 203,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'DJF' => [
            'name' => 'Djibouti Franc',
            'numericCode' => 262,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'DKK' => [
            'name' => 'Danish Krone',
            'numericCode' => 208,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'DOP' => [
            'name' => 'Dominican Peso',
            'numericCode' => 214,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'DZD' => [
            'name' => 'Algerian Dinar',
            'numericCode' => 12,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'EGP' => [
            'name' => 'Egyptian Pound',
            'numericCode' => 818,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ERN' => [
            'name' => 'Nakfa',
            'numericCode' => 232,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ETB' => [
            'name' => 'Ethiopian Birr',
            'numericCode' => 230,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'EUR' => [
            'name' => 'Euro',
            'numericCode' => 978,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'FJD' => [
            'name' => 'Fiji Dollar',
            'numericCode' => 242,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'FKP' => [
            'name' => 'Falkland Islands Pound',
            'numericCode' => 238,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'GBP' => [
            'name' => 'Pound Sterling',
            'numericCode' => 826,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'GEL' => [
            'name' => 'Lari',
            'numericCode' => 981,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'GHS' => [
            'name' => 'Ghana Cedi',
            'numericCode' => 936,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'GIP' => [
            'name' => 'Gibraltar Pound',
            'numericCode' => 292,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'GMD' => [
            'name' => 'Dalasi',
            'numericCode' => 270,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'GNF' => [
            'name' => 'Guinea Franc',
            'numericCode' => 324,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'GTQ' => [
            'name' => 'Quetzal',
            'numericCode' => 320,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'GYD' => [
            'name' => 'Guyana Dollar',
            'numericCode' => 328,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'HKD' => [
            'name' => 'Hong Kong Dollar',
            'numericCode' => 344,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'HNL' => [
            'name' => 'Lempira',
            'numericCode' => 340,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'HRK' => [
            'name' => 'Croatian Kuna',
            'numericCode' => 191,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'HTG' => [
            'name' => 'Gourde',
            'numericCode' => 332,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'HUF' => [
            'name' => 'Forint',
            'numericCode' => 348,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'IDR' => [
            'name' => 'Rupiah',
            'numericCode' => 360,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ILS' => [
            'name' => 'New Israeli Sheqel',
            'numericCode' => 376,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'INR' => [
            'name' => 'Indian Rupee',
            'numericCode' => 356,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'IQD' => [
            'name' => 'Iraqi Dinar',
            'numericCode' => 368,
            'fractionDecimals' => 3,
            'fractionUnit' => 1000,
        ],
        'IRR' => [
            'name' => 'Iranian Rial',
            'numericCode' => 364,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ISK' => [
            'name' => 'Iceland Krona',
            'numericCode' => 352,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'JMD' => [
            'name' => 'Jamaican Dollar',
            'numericCode' => 388,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'JOD' => [
            'name' => 'Jordanian Dinar',
            'numericCode' => 400,
            'fractionDecimals' => 3,
            'fractionUnit' => 100,
        ],
        'JPY' => [
            'name' => 'Yen',
            'numericCode' => 392,
            'fractionDecimals' => 0,
            'fractionUnit' => 1,
        ],
        'KES' => [
            'name' => 'Kenyan Shilling',
            'numericCode' => 404,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'KGS' => [
            'name' => 'Som',
            'numericCode' => 417,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'KHR' => [
            'name' => 'Riel',
            'numericCode' => 116,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'KMF' => [
            'name' => 'Comoro Franc',
            'numericCode' => 174,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'KPW' => [
            'name' => 'North Korean Won',
            'numericCode' => 408,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'KRW' => [
            'name' => 'Won',
            'numericCode' => 410,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'KWD' => [
            'name' => 'Kuwaiti Dinar',
            'numericCode' => 414,
            'fractionDecimals' => 3,
            'fractionUnit' => 1000,
        ],
        'KYD' => [
            'name' => 'Cayman Islands Dollar',
            'numericCode' => 136,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'KZT' => [
            'name' => 'Tenge',
            'numericCode' => 398,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'LAK' => [
            'name' => 'Kip',
            'numericCode' => 418,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'LBP' => [
            'name' => 'Lebanese Pound',
            'numericCode' => 422,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'LKR' => [
            'name' => 'Sri Lanka Rupee',
            'numericCode' => 144,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'LRD' => [
            'name' => 'Liberian Dollar',
            'numericCode' => 430,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'LSL' => [
            'name' => 'Loti',
            'numericCode' => 426,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'LYD' => [
            'name' => 'Libyan Dinar',
            'numericCode' => 434,
            'fractionDecimals' => 3,
            'fractionUnit' => 1000,
        ],
        'MAD' => [
            'name' => 'Moroccan Dirham',
            'numericCode' => 504,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MDL' => [
            'name' => 'Moldovan Leu',
            'numericCode' => 498,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MGA' => [
            'name' => 'Malagasy Ariary',
            'numericCode' => 969,
            'fractionDecimals' => 2,
            'fractionUnit' => 5,
        ],
        'MKD' => [
            'name' => 'Denar',
            'numericCode' => 807,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MMK' => [
            'name' => 'Kyat',
            'numericCode' => 104,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MNT' => [
            'name' => 'Tugrik',
            'numericCode' => 496,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MOP' => [
            'name' => 'Pataca',
            'numericCode' => 446,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MRO' => [
            'name' => 'Ouguiya',
            'numericCode' => 478,
            'fractionDecimals' => 2,
            'fractionUnit' => 5,
        ],
        'MUR' => [
            'name' => 'Mauritius Rupee',
            'numericCode' => 480,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MVR' => [
            'name' => 'Rufiyaa',
            'numericCode' => 462,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MWK' => [
            'name' => 'Kwacha',
            'numericCode' => 454,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MXN' => [
            'name' => 'Mexican Peso',
            'numericCode' => 484,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MXV' => [
            'name' => 'Mexican Unidad de Inversion (UDI)',
            'numericCode' => 979,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MYR' => [
            'name' => 'Malaysian Ringgit',
            'numericCode' => 458,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'MZN' => [
            'name' => 'Mozambique Metical',
            'numericCode' => 943,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'NAD' => [
            'name' => 'Namibia Dollar',
            'numericCode' => 516,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'NGN' => [
            'name' => 'Naira',
            'numericCode' => 566,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'NIO' => [
            'name' => 'Cordoba Oro',
            'numericCode' => 558,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'NOK' => [
            'name' => 'Norwegian Krone',
            'numericCode' => 578,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'NPR' => [
            'name' => 'Nepalese Rupee',
            'numericCode' => 524,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'NZD' => [
            'name' => 'New Zealand Dollar',
            'numericCode' => 554,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'OMR' => [
            'name' => 'Rial Omani',
            'numericCode' => 512,
            'fractionDecimals' => 3,
            'fractionUnit' => 1000,
        ],
        'PAB' => [
            'name' => 'Balboa',
            'numericCode' => 590,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'PEN' => [
            'name' => 'Nuevo Sol',
            'numericCode' => 604,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'PGK' => [
            'name' => 'Kina',
            'numericCode' => 598,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'PHP' => [
            'name' => 'Philippine Peso',
            'numericCode' => 608,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'PKR' => [
            'name' => 'Pakistan Rupee',
            'numericCode' => 586,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'PLN' => [
            'name' => 'Zloty',
            'numericCode' => 985,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'PYG' => [
            'name' => 'Guarani',
            'numericCode' => 600,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'QAR' => [
            'name' => 'Qatari Rial',
            'numericCode' => 634,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'RON' => [
            'name' => 'New Romanian Leu',
            'numericCode' => 946,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'RSD' => [
            'name' => 'Serbian Dinar',
            'numericCode' => 941,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'RUB' => [
            'name' => 'Russian Ruble',
            'numericCode' => 643,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'RWF' => [
            'name' => 'Rwanda Franc',
            'numericCode' => 646,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'SAR' => [
            'name' => 'Saudi Riyal',
            'numericCode' => 682,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SBD' => [
            'name' => 'Solomon Islands Dollar',
            'numericCode' => 90,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SCR' => [
            'name' => 'Seychelles Rupee',
            'numericCode' => 690,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SDG' => [
            'name' => 'Sudanese Pound',
            'numericCode' => 938,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SEK' => [
            'name' => 'Swedish Krona',
            'numericCode' => 752,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SGD' => [
            'name' => 'Singapore Dollar',
            'numericCode' => 702,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SHP' => [
            'name' => 'Saint Helena Pound',
            'numericCode' => 654,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SLL' => [
            'name' => 'Leone',
            'numericCode' => 694,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SOS' => [
            'name' => 'Somali Shilling',
            'numericCode' => 706,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SRD' => [
            'name' => 'Surinam Dollar',
            'numericCode' => 968,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SSP' => [
            'name' => 'South Sudanese Pound',
            'numericCode' => 728,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'STD' => [
            'name' => 'Dobra',
            'numericCode' => 678,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SYP' => [
            'name' => 'Syrian Pound',
            'numericCode' => 760,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'SZL' => [
            'name' => 'Lilangeni',
            'numericCode' => 748,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'THB' => [
            'name' => 'Baht',
            'numericCode' => 764,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'TJS' => [
            'name' => 'Somoni',
            'numericCode' => 972,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'TMT' => [
            'name' => 'Turkmenistan New Manat',
            'numericCode' => 934,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'TND' => [
            'name' => 'Tunisian Dinar',
            'numericCode' => 788,
            'fractionDecimals' => 3,
            'fractionUnit' => 1000,
        ],
        'TOP' => [
            'name' => 'Pa’anga',
            'numericCode' => 776,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'TRY' => [
            'name' => 'Turkish Lira',
            'numericCode' => 949,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'TTD' => [
            'name' => 'Trinidad and Tobago Dollar',
            'numericCode' => 780,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'TWD' => [
            'name' => 'New Taiwan Dollar',
            'numericCode' => 901,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'TZS' => [
            'name' => 'Tanzanian Shilling',
            'numericCode' => 834,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'UAH' => [
            'name' => 'Hryvnia',
            'numericCode' => 980,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'UGX' => [
            'name' => 'Uganda Shilling',
            'numericCode' => 800,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'USD' => [
            'name' => 'US Dollar',
            'numericCode' => 840,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'USN' => [
            'name' => 'US Dollar (Next day)',
            'numericCode' => 997,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'USS' => [
            'name' => 'US Dollar (Same day)',
            'numericCode' => 998,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'UYI' => [
            'name' => 'Uruguay Peso en Unidades Indexadas (URUIURUI)',
            'numericCode' => 940,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'UYU' => [
            'name' => 'Peso Uruguayo',
            'numericCode' => 858,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'UZS' => [
            'name' => 'Uzbekistan Sum',
            'numericCode' => 860,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'VEF' => [
            'name' => 'Bolivar',
            'numericCode' => 937,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'VND' => [
            'name' => 'Dong',
            'numericCode' => 704,
            'fractionDecimals' => 0,
            'fractionUnit' => 10,
        ],
        'VUV' => [
            'name' => 'Vatu',
            'numericCode' => 548,
            'fractionDecimals' => 0,
            'fractionUnit' => 1,
        ],
        'WST' => [
            'name' => 'Tala',
            'numericCode' => 882,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'XAF' => [
            'name' => 'CFA Franc BEAC',
            'numericCode' => 950,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XAG' => [
            'name' => 'Silver',
            'numericCode' => 961,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XAU' => [
            'name' => 'Gold',
            'numericCode' => 959,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XBA' => [
            'name' => 'Bond Markets Unit European Composite Unit (EURCO)',
            'numericCode' => 955,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XBB' => [
            'name' => 'Bond Markets Unit European Monetary Unit (E.M.U.-6)',
            'numericCode' => 956,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XBC' => [
            'name' => 'Bond Markets Unit European Unit of Account 9 (E.U.A.-9)',
            'numericCode' => 957,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XBD' => [
            'name' => 'Bond Markets Unit European Unit of Account 17 (E.U.A.-17)',
            'numericCode' => 958,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XCD' => [
            'name' => 'East Caribbean Dollar',
            'numericCode' => 951,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'XDR' => [
            'name' => 'SDR (Special Drawing Right)',
            'numericCode' => 960,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XFU' => [
            'name' => 'UIC-Franc',
            'numericCode' => 958,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XOF' => [
            'name' => 'CFA Franc BCEAO',
            'numericCode' => 952,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XPD' => [
            'name' => 'Palladium',
            'numericCode' => 964,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XPF' => [
            'name' => 'CFP Franc',
            'numericCode' => 953,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XPT' => [
            'name' => 'Platinum',
            'numericCode' => 962,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XSU' => [
            'name' => 'Sucre',
            'numericCode' => 994,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XTS' => [
            'name' => 'Codes specifically reserved for testing purposes',
            'numericCode' => 963,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XUA' => [
            'name' => 'ADB Unit of Account',
            'numericCode' => 965,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'XXX' => [
            'name' => 'The codes assigned for transactions where no currency is involved',
            'numericCode' => 999,
            'fractionDecimals' => 0,
            'fractionUnit' => 100,
        ],
        'YER' => [
            'name' => 'Yemeni Rial',
            'numericCode' => 886,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ZAR' => [
            'name' => 'Rand',
            'numericCode' => 710,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ],
        'ZMW' => [
            'name' => 'Zambian Kwacha',
            'numericCode' => 967,
            'fractionDecimals' => 2,
            'fractionUnit' => 100,
        ]
    ];

    /**
     * Private Constructor to disallow instantiation.
	 * @noinspection PhpMissingParentConstructorInspection
	 */
    private function __construct()
    {
    }

    /**
     * Returns the currency fraction unit.
     *
     * @param string $code the currency code.
     * @return int the currency fraction unit.
     * @throws NostoException
     */
    public static function getFractionUnit($code)
    {
        self::assertCurrency($code);
        return self::$data[$code]['fractionUnit'];
    }

    /**
     * Asserts that the currency code is supported.
     *
     * @param string $code the currency code to test.
     * @throws NostoException
     */
    private static function assertCurrency($code)
    {
        if (!isset(self::$data[$code])) {
            throw new NostoException(sprintf(
                'Currency (%s) must be one of the following ISO 4217 codes: "%s".',
                $code,
                implode('", "', array_keys(self::$data))
            ));
        }
    }

    /**
     * Returns the currency default fraction digit.
     *
     * @param string $code the currency code.
     * @return int the currency fraction digit.
     * @throws NostoException
     */
    public static function getFractionDecimals($code)
    {
        self::assertCurrency($code);
        return self::$data[$code]['fractionDecimals'];
    }
}
