<?php

interface NostoAccountMetaDataInterface
{
	/**
	 * @return string
	 */
	public function getTitle();

	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @return string
	 */
	public function getPlatform();

	/**
	 * @return string
	 */
	public function getFrontPageUrl();

	/**
	 * @return string
	 */
	public function getCurrencyCode();

	/**
	 * @return string
	 */
	public function getLanguageCode();

	/**
	 * @return string
	 */
	public function getOwnerLanguageCode();

	/**
	 * @return NostoAccountMetaDataOwnerInterface
	 */
	public function getOwner();

	/**
	 * @return NostoAccountMetaDataBillingDetailsInterface
	 */
	public function getBillingDetails();
}
