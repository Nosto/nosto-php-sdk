<?php

/**
 * Helper class for doing OAuth2 authorization with Nosto.
 * The client implements the 'Authorization Code' grant type.
 */
class NostoOAuthClient
{
	const PATH_AUTH = '?client_id={cid}&redirect_uri={uri}&response_type=code&scope={sco}&lang={iso}';
	const PATH_TOKEN = '/token?code={cod}&client_id={cid}&client_secret={sec}&redirect_uri={uri}&grant_type=authorization_code';

	/**
	 * @var string the nosto oauth endpoint base url.
	 */
	public static $baseUrl = 'https://my.nosto.com/oauth';

	/**
	 * @var string the client id the identify this application to the oauth2 server.
	 */
	protected $clientId = 'nosto';

	/**
	 * @var string the client secret the identify this application to the oauth2 server.
	 */
	protected $clientSecret = 'nosto';

	/**
	 * @var string the redirect url that will be used by the oauth2 server when authenticating the client.
	 */
	protected $redirectUrl;

	/**
	 * @var string the language ISO code used for localization on the oauth2 server.
	 */
	protected $languageIsoCode;

	/**
	 * @var array list of scopes to request access for during "PATH_AUTH" request.
	 */
	protected $scopes = array();

	/**
	 * @param NostoOAuthClientMetaDataInterface $metaData
	 */
	public function __construct(NostoOAuthClientMetaDataInterface $metaData)
	{
		$this->scopes = $metaData->getScopes();
		$this->clientId = $metaData->getClientId();
		$this->clientSecret = $metaData->getClientSecret();
		$this->redirectUrl = $metaData->getRedirectUrl();
		$this->languageIsoCode = $metaData->getLanguageIsoCode();
	}

	/**
	 * Returns the authorize url to the oauth2 server.
	 *
	 * @return string the url.
	 */
	public function getAuthorizationUrl()
	{
		return NostoHttpRequest::buildUri(
			self::$baseUrl.self::PATH_AUTH,
			array(
				'{cid}' => $this->clientId,
				'{uri}' => urlencode($this->redirectUrl),
				'{sco}' => implode(' ', $this->scopes),
				'{iso}' => strtolower($this->languageIsoCode),
			)
		);
	}

	/**
	 * Authenticates the application with the given code to receive an access token.
	 *
	 * @param string $code code sent by the authorization server to exchange for an access token.
	 * @return NostoOAuthToken
	 * @throws NostoException
	 */
	public function authenticate($code)
	{
		if (empty($code)) {
			throw new NostoException('Invalid authentication token');
		}

		$request = new NostoHttpRequest();
		$request->setUrl(self::$baseUrl.self::PATH_TOKEN);
		$request->setReplaceParams(array(
			'{cid}' => $this->clientId,
			'{sec}' => $this->clientSecret,
			'{uri}' => $this->redirectUrl,
			'{cod}' => $code
		));
		$response = $request->get();
		$result = $response->getJsonResult(true);

		if ($response->getCode() !== 200) {
			throw new NostoException('Failed to authenticate with code', $response->getCode());
		}
		if (empty($result['access_token'])) {
			throw new NostoException(' No "access_token" returned after authenticating with code');
		}
		if (empty($result['merchant_name'])) {
			throw new NostoException(' No "merchant_name" returned after authenticating with code');
		}

		return NostoOAuthToken::create($result);
	}
}
