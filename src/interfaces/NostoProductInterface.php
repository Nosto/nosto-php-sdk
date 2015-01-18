<?php

/**
 * Interface for the meta data of a product.
 * This is used when making product re-crawl API requests and product history exports to Nosto.
 */
interface NostoProductInterface
{
	/**
	 * Returns the absolute url to the product page in the shop frontend.
	 *
	 * @return string the url.
	 */
	public function getUrl();

	/**
	 * Returns the product's unique identifier.
	 *
	 * @return int|string the ID.
	 */
	public function getProductId();

	/**
	 * Returns the name of the product.
	 *
	 * @return string the name.
	 */
	public function getName();

	/**
	 * Returns the absolute url the one of the product images in the shop frontend.
	 *
	 * @return string the url.
	 */
	public function getImageUrl();

	/**
	 * Returns the price of the product including possible discounts and taxes.
	 *
	 * @return float the price with 2 decimals, e.g. 1000.99.
	 */
	public function getPrice();

	/**
	 * Returns the list price of the product without discounts but including possible taxes.
	 *
	 * @return float the price with 2 decimals, e.g. 1000.99.
	 */
	public function getListPrice();

	/**
	 * Returns the currency code (ISO 4217) the product is sold in.
	 *
	 * @return string the currency ISO code.
	 */
	public function getCurrencyCode();

	/**
	 * Returns the availability of the product, i.e. if it is in stock or not.
	 *
	 * @return string the availability, either "InStock" or "OutOfStock".
	 */
	public function getAvailability();

	/**
	 * Returns the tags for the product.
	 *
	 * @return array the tags array, e.g. array("winter", "shoe").
	 */
	public function getTags();

	/**
	 * Returns the categories the product is located in.
	 *
	 * @return array list of category strings, e.g. array("/shoes/winter", "shoes/boots").
	 */
	public function getCategories();

	/**
	 * Returns the product description.
	 *
	 * @return string the description.
	 */
	public function getDescription();

	/**
	 * Returns the product brand name.
	 *
	 * @return string the brand name.
	 */
	public function getBrand();

	/**
	 * Returns the product publication date in the shop.
	 *
	 * @return string the date in format "Y-m-d".
	 */
	public function getDatePublished();
}
