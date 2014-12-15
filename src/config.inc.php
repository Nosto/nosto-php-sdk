<?php

// Interfaces
require_once(dirname(__FILE__).'/interfaces/NostoAccountInterface.php');
require_once(dirname(__FILE__).'/interfaces/NostoAccountMetaDataBillingDetailsInterface.php');
require_once(dirname(__FILE__).'/interfaces/NostoAccountMetaDataIframeInterface.php');
require_once(dirname(__FILE__).'/interfaces/NostoAccountMetaDataInterface.php');
require_once(dirname(__FILE__).'/interfaces/NostoAccountMetaDataOwnerInterface.php');
require_once(dirname(__FILE__).'/interfaces/NostoOAuthClientMetaDataInterface.php');

// Classes
require_once(dirname(__FILE__).'/classes/NostoAccount.php');
require_once(dirname(__FILE__).'/classes/NostoHttpRequest.php');
require_once(dirname(__FILE__).'/classes/NostoApiRequest.php');
require_once(dirname(__FILE__).'/classes/NostoApiToken.php');
require_once(dirname(__FILE__).'/classes/NostoCipher.php');
require_once(dirname(__FILE__).'/classes/NostoDotEnv.php');
require_once(dirname(__FILE__).'/classes/NostoException.php');
require_once(dirname(__FILE__).'/classes/NostoHttpRequestAdapter.php');
require_once(dirname(__FILE__).'/classes/NostoHttpRequestAdapterCurl.php');
require_once(dirname(__FILE__).'/classes/NostoHttpRequestAdapterSocket.php');
require_once(dirname(__FILE__).'/classes/NostoHttpResponse.php');
require_once(dirname(__FILE__).'/classes/NostoOAuthClient.php');
require_once(dirname(__FILE__).'/classes/NostoOAuthToken.php');

// Parse .env if exists and assign configured environment variables.
NostoDotEnv::getInstance()->init(__DIR__);
if (isset($_ENV['NOSTO_API_BASE_URL'])) {
	NostoApiRequest::$baseUrl = $_ENV['NOSTO_API_BASE_URL'];
}
if (isset($_ENV['NOSTO_OAUTH_BASE_URL'])) {
	NostoOAuthClient::$baseUrl = $_ENV['NOSTO_OAUTH_BASE_URL'];
}
