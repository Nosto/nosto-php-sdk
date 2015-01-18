<?php

/**
 * Interface for the OAuth2 client.
 * The client implements the "Authorization Code" OAuth2 spec.
 * @see https://tools.ietf.org/html/rfc6749
 */
interface NostoOAuthClientMetaDataInterface
{
	/**
	 * The OAuth2 client ID.
	 * This will be a platform specific ID that Nosto will issue.
	 *
	 * @return string the client id.
	 */
	public function getClientId();

	/**
	 * The OAuth2 client secret.
	 * This will be a platform specific secret that Nosto will issue.
	 *
	 * @return string the client secret.
	 */
	public function getClientSecret();

	/**
	 * The OAuth2 redirect url to where the OAuth2 server should redirect the user after authorizing the application to act on the users behalf.
	 * This url must by publicly accessible and the domain must match the one defined for the Nosto account.
	 *
	 * @return string the url.
	 */
	public function getRedirectUrl();

	/**
	 * The scopes for the OAuth2 request.
	 * These are used to request specific API tokens from Nosto and should almost always be the ones defined in NostoApiToken::$tokenNames.
	 *
	 * @return array the scopes.
	 */
	public function getScopes();

	/**
	 * The 2-letter ISO code (ISO 639-1) for the language the OAuth2 server uses for UI localization.
	 *
	 * @return string the ISO code.
	 */
	public function getLanguageIsoCode();
}
