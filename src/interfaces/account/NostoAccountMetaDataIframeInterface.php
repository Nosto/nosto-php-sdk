<?php

/**
 * Interface for the meta data needed for the account configuration iframe.
 */
interface NostoAccountMetaDataIframeInterface
{
	/**
	 * The name of the platform the iframe is used on.
	 * A list of valid platform names is issued by Nosto.
	 *
	 * @return string the platform name.
	 */
	public function getPlatform();

	/**
	 * The first name of the user who is loading the config iframe.
	 *
	 * @return string the first name.
	 */
	public function getFirstName();

	/**
	 * The last name of the user who is loading the config iframe.
	 *
	 * @return string the last name.
	 */
	public function getLastName();

	/**
	 * The email address of the user who is loading the config iframe.
	 *
	 * @return string the email address.
	 */
	public function getEmail();

	/**
	 * The 2-letter ISO code (ISO 639-1) for the language of the user who is loading the config iframe.
	 *
	 * @return string the language ISO code.
	 */
	public function getLanguageIsoCode();

	/**
	 * The 2-letter ISO code (ISO 639-1) for the language of the shop the account belongs to.
	 *
	 * @return string the language ISO code.
	 */
	public function getLanguageIsoCodeShop();

	/**
	 * Unique identifier for the e-commerce installation.
	 * This identifier is used to link accounts together that are created on the same installation.
	 *
	 * @return string the identifier.
	 */
	public function getUniqueId();

	/**
	 * The version number of the platform the e-commerce installation is running on.
	 *
	 * @return string the platform version.
	 */
	public function getVersionPlatform();

	/**
	 * The version number of the Nosto module/extension running on the e-commerce installation.
	 *
	 * @return string the module version.
	 */
	public function getVersionModule();

	/**
	 * An absolute URL for any product page in the shop the account is linked to, with the nostodebug GET parameter enabled.
	 * e.g. http://myshop.com/products/product123?nostodebug=true
	 * This is used in the config iframe to allow the user to quickly preview the recommendations on the given page.
	 *
	 * @return string the url.
	 */
	public function getPreviewUrlProduct();

	/**
	 * An absolute URL for any category page in the shop the account is linked to, with the nostodebug GET parameter enabled.
	 * e.g. http://myshop.com/products/category123?nostodebug=true
	 * This is used in the config iframe to allow the user to quickly preview the recommendations on the given page.
	 *
	 * @return string the url.
	 */
	public function getPreviewUrlCategory();

	/**
	 * An absolute URL for the search page in the shop the account is linked to, with the nostodebug GET parameter enabled.
	 * e.g. http://myshop.com/search?query=red?nostodebug=true
	 * This is used in the config iframe to allow the user to quickly preview the recommendations on the given page.
	 *
	 * @return string the url.
	 */
	public function getPreviewUrlSearch();

	/**
	 * An absolute URL for the shopping cart page in the shop the account is linked to, with the nostodebug GET parameter enabled.
	 * e.g. http://myshop.com/cart?nostodebug=true
	 * This is used in the config iframe to allow the user to quickly preview the recommendations on the given page.
	 *
	 * @return string the url.
	 */
	public function getPreviewUrlCart();

	/**
	 * An absolute URL for the front page in the shop the account is linked to, with the nostodebug GET parameter enabled.
	 * e.g. http://myshop.com?nostodebug=true
	 * This is used in the config iframe to allow the user to quickly preview the recommendations on the given page.
	 *
	 * @return string the url.
	 */
	public function getPreviewUrlFront();
}
