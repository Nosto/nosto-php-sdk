<?php

interface NostoAccountMetaDataIframeInterface
{
	/**
	 * @return string
	 */
	public function getFirstName();

	/**
	 * @return string
	 */
	public function getLastName();

	/**
	 * @return string
	 */
	public function getEmail();

	/**
	 * @return string
	 */
	public function getLanguageIsoCode();

	/**
	 * @return string
	 */
	public function getLanguageIsoCodeShop();

	/**
	 * @return string
	 */
	public function getUniqueId();

	/**
	 * @return string
	 */
	public function getVersionPlatform();

	/**
	 * @return string
	 */
	public function getVersionModule();

	/**
	 * @return string
	 */
	public function getPreviewUrlProduct();

	/**
	 * @return string
	 */
	public function getPreviewUrlCategory();

	/**
	 * @return string
	 */
	public function getPreviewUrlSearch();

	/**
	 * @return string
	 */
	public function getPreviewUrlCart();

	/**
	 * @return string
	 */
	public function getPreviewUrlFront();
}
