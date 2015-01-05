<?php

/**
 * Interface for the meta data model used when creating new Nosto accounts.
 */
interface NostoAccountMetaDataInterface
{
	/**
	 * The shops name for which the account is to be created for.
	 *
	 * @return string the name.
	 */
	public function getTitle();

	/**
	 * The name of the account to create.
	 * This has to follow the pattern of "[platform name]-[8 character lowercase alpha numeric string]".
	 *
	 * @return string the account name.
	 */
	public function getName();

	/**
	 * The name of the platform the account is used on.
	 * A list of valid platform names is issued by Nosto.
	 *
	 * @return string the platform names.
	 */
	public function getPlatform();

	/**
	 * Absolute url to the front page of the shop for which the account is created for.
	 *
	 * @return string the url.
	 */
	public function getFrontPageUrl();

	/**
	 * The 3-letter ISO code (ISO 4217) for the currency used by the shop for which the account is created for.
	 *
	 * @return string the currency ISO code.
	 */
	public function getCurrencyCode();

	/**
	 * The 3-letter ISO code (ISO 639-2) for the language used by the shop for which the account is created for.
	 *
	 * @return string the language ISO code.
	 */
	public function getLanguageCode();

	/**
	 * The 3-letter ISO code (ISO 639-2) for the language of the account owner who is creating the account.
	 *
	 * @return string the language ISO code.
	 */
	public function getOwnerLanguageCode();

	/**
	 * Meta data model for the account owner who is creating the account.
	 *
	 * @return NostoAccountMetaDataOwnerInterface the meta data model.
	 */
	public function getOwner();

	/**
	 * Meta data model for the account billing details.
	 *
	 * @return NostoAccountMetaDataBillingDetailsInterface the meta data model.
	 */
	public function getBillingDetails();

	/**
	 * The API token used to identify an account creation.
	 * This token is platform specific and issued by Nosto.
	 *
	 * @return string the API token.
	 */
	public function getSignUpApiToken();
}
