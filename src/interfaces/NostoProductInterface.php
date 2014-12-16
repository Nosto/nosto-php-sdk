<?php

/**
 * Interface for the meta data of a product.
 * This is used when making product re-crawl API requests to Nosto.
 */
interface NostoProductInterface
{
	/**
	 * Returns the product's unique identifier.
	 *
	 * @return int|string the ID.
	 */
	public function getId();
}
