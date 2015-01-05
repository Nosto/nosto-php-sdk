<?php

/**
 * Nosto account class for handling account related actions like, creation, OAuth2 syncing and SSO to Nosto.
 */
class NostoAccount implements NostoAccountInterface
{
	const IFRAME_URI = '/hub/prestashop/{m}';

	/**
	 * @var string the name of the Nosto account.
	 */
	public $name;

	/**
	 * @var NostoApiToken[] the Nosto API tokens associated with this account.
	 */
	public $tokens = array();

	/**
	 * @inheritdoc
	 */
	public static function create(NostoAccountMetaDataInterface $meta)
	{
		$params = array(
			'title' => $meta->getTitle(),
			'name' => $meta->getName(),
			'platform' => $meta->getPlatform(),
			'front_page_url' => $meta->getFrontPageUrl(),
			'currency_code' => $meta->getCurrencyCode(),
			'language_code' => $meta->getOwnerLanguageCode(),
			'owner' => array(
				'first_name' => $meta->getOwner()->getFirstName(),
				'last_name' => $meta->getOwner()->getLastName(),
				'email' => $meta->getOwner()->getEmail(),
			),
			'billing_details' => array(
				'country' => $meta->getBillingDetails()->getCountry(),
			),
			'api_tokens' => array(),
		);

		foreach (NostoApiToken::$tokenNames as $name) {
			$params['api_tokens'][] = 'api_' . $name;
		}

		$request = new NostoApiRequest();
		$request->setPath(NostoApiRequest::PATH_SIGN_UP);
		$request->setReplaceParams(array('{lang}' => $meta->getLanguageCode()));
		$request->setContentType('application/json');
		$request->setAuthBasic('', $meta->getSignUpApiToken());
		$response = $request->post(json_encode($params));

		if ($response->getCode() !== 200) {
			throw new NostoException('Nosto account could not be created', $response->getCode());
		}

		$account = new self;
		$account->name = $meta->getPlatform().'-'.$meta->getName();
		$account->tokens = NostoApiToken::parseTokens($response->getJsonResult(true), '', '_token');
		return $account;
	}

	/**
	 * @inheritdoc
	 */
	public static function syncFromNosto(NostoOAuthClientMetaDataInterface $meta, $code)
	{
		$oauthClient = new NostoOAuthClient($meta);
		$token = $oauthClient->authenticate($code);

		if (empty($token->accessToken)) {
			throw new NostoException('No access token found when trying to sync account from Nosto');
		}
		if (empty($token->merchantName)) {
			throw new NostoException('No merchant name found when trying to sync account from Nosto');
		}

		$request = new NostoHttpRequest();
		// The request is currently not made according the the OAuth2 spec with the access token in the
		// Authorization header. This is due to the authentication server not implementing the full OAuth2 spec yet.
		$request->setUrl(NostoOAuthClient::$baseUrl.'/exchange');
		$request->setQueryParams(array('access_token' => $token->accessToken));
		$response = $request->get();
		$result = $response->getJsonResult(true);

		if ($response->getCode() !== 200) {
			throw new NostoException('Failed to sync account from Nosto', $response->getCode());
		}
		if (empty($result)) {
			throw new NostoException('Received invalid data from Nosto when trying to sync account');
		}

		$account = new self;
		$account->name = $token->merchantName;
		$account->tokens = NostoApiToken::parseTokens($result, 'api_');
		if (!$account->isConnectedToNosto()) {
			throw new NostoException('Failed to sync all account details from Nosto');
		}
		return $account;
	}

	/**
	 * @inheritdoc
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @inheritdoc
	 */
	public function isConnectedToNosto()
	{
		if (empty($this->tokens)) {
			return false;
		}
		$countTokens = count($this->tokens);
		$foundTokens = 0;
		foreach (NostoApiToken::$tokenNames as $name) {
			foreach ($this->tokens as $token) {
				if ($token->name === $name) {
					$foundTokens++;
					break;
				}
			}
		}
		return ($countTokens === $foundTokens);
	}

	/**
	 * @inheritdoc
	 */
	public function getApiToken($name)
	{
		foreach ($this->tokens as $token) {
			if ($token->name === $name) {
				return $token;
			}
		}
		return null;
	}

	/**
	 * @inheritdoc
	 */
	public function getIframeUrl(NostoAccountMetaDataIframeInterface $meta)
	{
		$url = $this->ssoLogin($meta);
		if (!empty($url)) {
			return $url.'?r='.urlencode(NostoHttpRequest::buildUri(
					self::IFRAME_URI.'?'.http_build_query(array(
						// Params copied from PS
						'lang' => $meta->getLanguageIsoCode(),
						'ps_version' => $meta->getVersionPlatform(),
						'nt_version' => $meta->getVersionModule(),
						'product_pu' => $meta->getPreviewUrlProduct(),
						'category_pu' => $meta->getPreviewUrlCategory(),
						'search_pu' => $meta->getPreviewUrlSearch(),
						'cart_pu' => $meta->getPreviewUrlCart(),
						'front_pu' => $meta->getPreviewUrlFront(),
						'shop_lang' => $meta->getLanguageIsoCodeShop(),
						'unique_id' => $meta->getUniqueId(),
						// Params we would like for them all...
//						'lang' => $meta->getLanguageIsoCode(),
//						'lang_shop' => $meta->getLanguageIsoCodeShop(),
//						'unique_id' => $meta->getUniqueId(),
//						'version_platform' => $meta->getVersionPlatform(),
//						'version_module' => $meta->getVersionModule(),
//						'preview_product' => $meta->getPreviewUrlProduct(),
//						'preview_category' => $meta->getPreviewUrlCategory(),
//						'preview_search' => $meta->getPreviewUrlSearch(),
//						'preview_cart' => $meta->getPreviewUrlCart(),
//						'preview_front' => $meta->getPreviewUrlFront(),
					)),
					array(
						'{m}' => $this->name
					)
				));
		} else {
			return false;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function ssoLogin(NostoAccountMetaDataIframeInterface $meta)
	{
		$token = $this->getApiToken('sso');
		if ($token === null) {
			return false;
		}

		$request = new NostoApiRequest();
		$request->setPath(NostoApiRequest::PATH_SSO_AUTH);
		$request->setReplaceParams(array('{email}' => $meta->getEmail()));
		$request->setContentType('application/json');
		$request->setAuthBasic('', $token->value);
		$response = $request->post(json_encode(array(
			'first_name' => $meta->getFirstName(),
			'last_name' => $meta->getLastName(),
		)));
		$result = $response->getJsonResult();

		if ($response->getCode() !== 200) {
			throw new NostoException('Unable to login employee to Nosto with SSO token', $response->getCode());
		}
		if (empty($result->login_url)) {
			throw new NostoException('No "login_url" returned when logging in employee to Nosto');
		}

		return $result->login_url;
	}
}
