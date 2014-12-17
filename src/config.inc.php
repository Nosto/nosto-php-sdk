<?php

// Interfaces
require_once(dirname(__FILE__).'/interfaces/account/NostoAccountInterface.php');
require_once(dirname(__FILE__).'/interfaces/account/NostoAccountMetaDataBillingDetailsInterface.php');
require_once(dirname(__FILE__).'/interfaces/account/NostoAccountMetaDataIframeInterface.php');
require_once(dirname(__FILE__).'/interfaces/account/NostoAccountMetaDataInterface.php');
require_once(dirname(__FILE__).'/interfaces/account/NostoAccountMetaDataOwnerInterface.php');
require_once(dirname(__FILE__).'/interfaces/NostoOAuthClientMetaDataInterface.php');
require_once(dirname(__FILE__).'/interfaces/order/NostoOrderBuyerInterface.php');
require_once(dirname(__FILE__).'/interfaces/order/NostoOrderInterface.php');
require_once(dirname(__FILE__).'/interfaces/order/NostoOrderPurchasedItemInterface.php');
require_once(dirname(__FILE__).'/interfaces/NostoProductInterface.php');

// Classes
require_once(dirname(__FILE__).'/classes/NostoAccount.php');
require_once(dirname(__FILE__).'/classes/http/NostoHttpRequest.php');
require_once(dirname(__FILE__).'/classes/api/NostoApiRequest.php');
require_once(dirname(__FILE__).'/classes/api/NostoApiToken.php');
require_once(dirname(__FILE__).'/classes/NostoCipher.php');
require_once(dirname(__FILE__).'/classes/NostoDotEnv.php');
require_once(dirname(__FILE__).'/classes/NostoException.php');
require_once(dirname(__FILE__).'/classes/http/NostoHttpRequestAdapter.php');
require_once(dirname(__FILE__).'/classes/http/NostoHttpRequestAdapterCurl.php');
require_once(dirname(__FILE__).'/classes/http/NostoHttpRequestAdapterSocket.php');
require_once(dirname(__FILE__).'/classes/http/NostoHttpResponse.php');
require_once(dirname(__FILE__).'/classes/oauth/NostoOAuthClient.php');
require_once(dirname(__FILE__).'/classes/oauth/NostoOAuthToken.php');
require_once(dirname(__FILE__).'/classes/NostoOrderConfirmation.php');
require_once(dirname(__FILE__).'/classes/NostoProductReCrawl.php');

require_once(dirname(__FILE__).'/classes/export/NostoExporter.php');
require_once(dirname(__FILE__).'/classes/export/NostoExportCollection.php');
require_once(dirname(__FILE__).'/classes/export/NostoExportProductCollection.php');
require_once(dirname(__FILE__).'/classes/export/NostoExportOrderCollection.php');

// Libs
require_once(dirname(__FILE__).'/libs/phpseclib/crypt/NostoCryptBase.php');
require_once(dirname(__FILE__).'/libs/phpseclib/crypt/NostoCryptRijndael.php');
require_once(dirname(__FILE__).'/libs/phpseclib/crypt/NostoCryptAES.php');
require_once(dirname(__FILE__).'/libs/phpseclib/crypt/NostoCryptRandom.php');

// Parse .env if exists and assign configured environment variables.
NostoDotEnv::getInstance()->init(__DIR__);
if (isset($_ENV['NOSTO_API_BASE_URL'])) {
	NostoApiRequest::$baseUrl = $_ENV['NOSTO_API_BASE_URL'];
}
if (isset($_ENV['NOSTO_OAUTH_BASE_URL'])) {
	NostoOAuthClient::$baseUrl = $_ENV['NOSTO_OAUTH_BASE_URL'];
}
