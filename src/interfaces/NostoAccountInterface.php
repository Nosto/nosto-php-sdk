<?php

/**
 * Interface for the Nosto account model that handles creation, syncing and SSO access for the Nosto account.
 */
interface NostoAccountInterface
{
	/**
	 * Creates a new Nosto account with the specified data.
	 *
	 * @param NostoAccountMetaDataInterface $meta the account data model.
	 * @return NostoAccount the newly created account.
	 * @throws NostoException if the account cannot be created.
	 */
	public static function create(NostoAccountMetaDataInterface $meta);

	/**
	 * Syncs an existing Nosto account via Oauth2.
	 * Requires that the oauth cycle has already completed the first step in getting the authorization code.
	 *
	 * @param NostoOAuthClientMetaDataInterface $meta the oauth2 client meta data to use for connection to Nosto.
	 * @param string $code the authorization code that grants access to transfer data from nosto.
	 * @return NostoAccount the synced account.
	 * @throws NostoException if the account cannot be synced.
	 */
	public static function syncFromNosto(NostoOAuthClientMetaDataInterface $meta, $code);

	/**
	 * Checks if this account has been connected to Nosto, i.e. all API tokens exist.
	 *
	 * @return bool true if it is connected, false otherwise.
	 */
	public function isConnectedToNosto();

	/**
	 * Gets an api token associated with this account by it's name , e.g. "sso".
	 *
	 * @param string $name the api token name.
	 * @return NostoApiToken|null the token or null if not found.
	 */
	public function getApiToken($name);

	/**
	 * Gets the secured iframe url for the account configuration page.
	 *
	 * @param NostoAccountMetaDataIframeInterface $meta the iframe meta data to use for fetching the secured url.
	 * @return bool|string the url or false if could not be fetched.
	 */
	public function getIframeUrl(NostoAccountMetaDataIframeInterface $meta);

	/**
	 * Signs the user in to Nosto via SSO.
	 * Requires that the account has a valid sso token associated with it.
	 *
	 * @param NostoAccountMetaDataIframeInterface $meta the iframe meta data model.
	 * @return string a secure login url that can be used for example to build the config iframe url.
	 * @throws NostoException if SSO fails.
	 */
	public function ssoLogin(NostoAccountMetaDataIframeInterface $meta);
}
