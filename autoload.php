<?php
/**
 * Copyright (c) 2015, Nosto Solutions Ltd
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
 * @copyright 2015 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 */

require_once(dirname(__FILE__).'/src/ValidatableInterface.php');
require_once(dirname(__FILE__).'/src/Object.php');
require_once(dirname(__FILE__).'/src/AccountInterface.php');
require_once(dirname(__FILE__).'/src/Account.php');
require_once(dirname(__FILE__).'/src/Cipher.php');
require_once(dirname(__FILE__).'/src/Collection.php');
require_once(dirname(__FILE__).'/src/Currency.php');
require_once(dirname(__FILE__).'/src/DotEnv.php');
require_once(dirname(__FILE__).'/src/Exception.php');
require_once(dirname(__FILE__).'/src/Exporter.php');
require_once(dirname(__FILE__).'/src/Helper.php');
require_once(dirname(__FILE__).'/src/Message.php');
require_once(dirname(__FILE__).'/src/Nosto.php');
require_once(dirname(__FILE__).'/src/Validator.php');
require_once(dirname(__FILE__).'/src/Http/Request.php');
require_once(dirname(__FILE__).'/src/Account/MetaInterface.php');
require_once(dirname(__FILE__).'/src/Account/Meta/BillingInterface.php');
require_once(dirname(__FILE__).'/src/Account/Meta/IframeInterface.php');
require_once(dirname(__FILE__).'/src/Account/Meta/OwnerInterface.php');
require_once(dirname(__FILE__).'/src/Api/Request.php');
require_once(dirname(__FILE__).'/src/Api/Token.php');
require_once(dirname(__FILE__).'/src/Crypt/Base.php');
require_once(dirname(__FILE__).'/src/Crypt/Rijndael.php');
require_once(dirname(__FILE__).'/src/Crypt/AES.php');
require_once(dirname(__FILE__).'/src/Crypt/Random.php');
require_once(dirname(__FILE__).'/src/Currency/Exchange/Rate.php');
require_once(dirname(__FILE__).'/src/Currency/Exchange/Rate/Collection.php');
require_once(dirname(__FILE__).'/src/Export/CollectionInterface.php');
require_once(dirname(__FILE__).'/src/Order/Collection.php');
require_once(dirname(__FILE__).'/src/Export/Collection/Order.php');
require_once(dirname(__FILE__).'/src/Product/Collection.php');
require_once(dirname(__FILE__).'/src/Export/Collection/Product.php');
require_once(dirname(__FILE__).'/src/Helper/Date.php');
require_once(dirname(__FILE__).'/src/Helper/Iframe.php');
require_once(dirname(__FILE__).'/src/Helper/Price.php');
require_once(dirname(__FILE__).'/src/Http/Exception.php');
require_once(dirname(__FILE__).'/src/Http/Response.php');
require_once(dirname(__FILE__).'/src/Http/Request/Adapter.php');
require_once(dirname(__FILE__).'/src/Http/Request/Adapter/Curl.php');
require_once(dirname(__FILE__).'/src/Http/Request/Adapter/Socket.php');
require_once(dirname(__FILE__).'/src/Oauth/Client/MetaInterface.php');
require_once(dirname(__FILE__).'/src/Oauth/Client.php');
require_once(dirname(__FILE__).'/src/Oauth/Token.php');
require_once(dirname(__FILE__).'/src/OrderInterface.php');
require_once(dirname(__FILE__).'/src/Order/BuyerInterface.php');
require_once(dirname(__FILE__).'/src/Order/ItemInterface.php');
require_once(dirname(__FILE__).'/src/Order/StatusInterface.php');
require_once(dirname(__FILE__).'/src/ProductInterface.php');
require_once(dirname(__FILE__).'/src/Product/Price/VariationInterface.php');
require_once(dirname(__FILE__).'/src/Service/Confirm/Order.php');
require_once(dirname(__FILE__).'/src/Service/Recrawl/Product.php');
require_once(dirname(__FILE__).'/src/Service/Update/Product.php');
require_once(dirname(__FILE__).'/src/Service/Update/Currency/Exchange/Rate.php');
require_once(dirname(__FILE__).'/src/Validator/Currency.php');
require_once(dirname(__FILE__).'/src/Validator/Number.php');
require_once(dirname(__FILE__).'/src/Validator/Range.php');
require_once(dirname(__FILE__).'/src/Validator/Required.php');

// Parse .env if exists and assign configured environment variables.
NostoDotEnv::getInstance()->init(dirname(__FILE__));
if (isset($_ENV['NOSTO_API_BASE_URL'])) {
    NostoApiRequest::$baseUrl = $_ENV['NOSTO_API_BASE_URL'];
}
if (isset($_ENV['NOSTO_OAUTH_BASE_URL'])) {
    NostoOAuthClient::$baseUrl = $_ENV['NOSTO_OAUTH_BASE_URL'];
}
if (isset($_ENV['NOSTO_WEB_HOOK_BASE_URL'])) {
    NostoHttpRequest::$baseUrl = $_ENV['NOSTO_WEB_HOOK_BASE_URL'];
}
