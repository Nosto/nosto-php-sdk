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

require_once(dirname(__FILE__) . '/interfaces/PersonInterface.php');
require_once(dirname(__FILE__) . '/interfaces/SettingsInterface.php');
require_once(dirname(__FILE__) . '/interfaces/Signup/Details.php');
require_once(dirname(__FILE__) . '/interfaces/Signup/Signup.php');
require_once(dirname(__FILE__) . '/interfaces/Signup/Owner.php');

require_once(dirname(__FILE__) . '/interfaces/Order/NostoOrderBuyerInterface.php');
require_once(dirname(__FILE__) . '/interfaces/Order/Order.php');
require_once(dirname(__FILE__) . '/interfaces/Order/Status.php');

require_once(dirname(__FILE__) . '/interfaces/SkuInterface.php');
require_once(dirname(__FILE__) . '/interfaces/Iframe.php');
require_once(dirname(__FILE__) . '/interfaces/OAuthInterface.php');
require_once(dirname(__FILE__) . '/interfaces/Product.php');
require_once(dirname(__FILE__) . '/interfaces/ValidatableInterface.php');
require_once(dirname(__FILE__) . '/interfaces/SyncRates.php');
require_once(dirname(__FILE__) . '/interfaces/Account.php');
require_once(dirname(__FILE__) . '/interfaces/NostoNotificationInterface.php');
require_once(dirname(__FILE__) . '/interfaces/UserInterface.php');
require_once(dirname(__FILE__) . '/interfaces/NostoLineItem.php');

require_once(dirname(__FILE__) . '/classes/http/Request.php');
require_once(dirname(__FILE__) . '/classes/Object.php');

require_once(dirname(__FILE__) . '/classes/api/Request.php');
require_once(dirname(__FILE__) . '/classes/api/Token.php');

require_once(dirname(__FILE__) . '/classes/collection/Collection.php');
require_once(dirname(__FILE__) . '/classes/collection/Productc.php');
require_once(dirname(__FILE__) . '/classes/collection/Order .php');
require_once(dirname(__FILE__) . '/classes/collection/Rates.php');

require_once(dirname(__FILE__) . '/classes/exception/NostoException.php');
require_once(dirname(__FILE__) . '/classes/exception/HttpException.php');
require_once(dirname(__FILE__) . '/classes/exception/HttpResponseException.php');
require_once(dirname(__FILE__) . '/classes/exception/ApiResponseException.php');

require_once(dirname(__FILE__) . '/classes/helper/Helper.php');
require_once(dirname(__FILE__) . '/classes/helper/Exporter.php');
require_once(dirname(__FILE__) . '/classes/helper/Date.php');
require_once(dirname(__FILE__) . '/classes/helper/Iframe.php');
require_once(dirname(__FILE__) . '/classes/helper/Price.php');
require_once(dirname(__FILE__) . '/classes/helper/Serializer.php');

require_once(dirname(__FILE__) . '/classes/iframe/NostoIframeMixin.php');

require_once(dirname(__FILE__) . '/classes/http/HttpRequestAdapter.php');
require_once(dirname(__FILE__) . '/classes/http/HttpRequestAdapterCurl.php');
require_once(dirname(__FILE__) . '/classes/http/HttpRequestAdapterSocket.php');
require_once(dirname(__FILE__) . '/classes/http/HttpResponse.php');

require_once(dirname(__FILE__) . '/classes/oauth/OAuthClient.php');
require_once(dirname(__FILE__) . '/classes/oauth/NostoOAuthToken.php');

require_once(dirname(__FILE__) . '/classes/operation/NostoOperation.php');
require_once(dirname(__FILE__) . '/classes/operation/NostoOperationProduct.php');
require_once(dirname(__FILE__) . '/classes/operation/SyncRates.php');
require_once(dirname(__FILE__) . '/classes/operation/Signup.php');
require_once(dirname(__FILE__) . '/classes/operation/UpdateSettings.php');
require_once(dirname(__FILE__) . '/classes/operation/NostoOperationUninstall.php');
require_once(dirname(__FILE__) . '/classes/operation/NostoOperationSso.php');
require_once(dirname(__FILE__) . '/classes/operation/Order.php');
require_once(dirname(__FILE__) . '/classes/operation/Sync.php');

require_once(dirname(__FILE__) . '/classes/Nosto.php');
require_once(dirname(__FILE__) . '/classes/Cart.php');
require_once(dirname(__FILE__) . '/classes/LineItem.php');
require_once(dirname(__FILE__) . '/classes/Product.php');
require_once(dirname(__FILE__) . '/classes/Account.php');
require_once(dirname(__FILE__) . '/classes/UpdateSettings.php');
require_once(dirname(__FILE__) . '/classes/Iframe.php');
require_once(dirname(__FILE__) . '/classes/Billing.php');
require_once(dirname(__FILE__) . '/classes/Signup.php');
require_once(dirname(__FILE__) . '/classes/Sku.php');
require_once(dirname(__FILE__) . '/classes/NostoCipher.php');
require_once(dirname(__FILE__) . '/classes/NostoValidator.php');
require_once(dirname(__FILE__) . '/classes/SyncRates.php');
require_once(dirname(__FILE__) . '/classes/NostoCurrencyFormat.php');
require_once(dirname(__FILE__) . '/classes/NostoCurrencyInfo.php');
require_once(dirname(__FILE__) . '/classes/Person.php');
require_once(dirname(__FILE__) . '/classes/Owner.php');
require_once(dirname(__FILE__) . '/classes/User.php');
require_once(dirname(__FILE__) . '/classes/Notification.php');
require_once(dirname(__FILE__) . '/classes/Buyer.php');
require_once(dirname(__FILE__) . '/classes/Status.php');
require_once(dirname(__FILE__) . '/classes/Order.php');
require_once(dirname(__FILE__) . '/classes/OAuth.php');
