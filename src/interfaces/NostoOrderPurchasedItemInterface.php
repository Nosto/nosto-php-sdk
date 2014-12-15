<?php

/**
 * Interface for an purchased item in an order.
 * This is used by the NostoOrderInterface meta data model when sending order confirmation API requests.
 *
 * The purchased item should also be used for shipping costs, discounts or other similar data.
 */
interface NostoOrderPurchasedItemInterface
{
	/**
	 * The unique identifier of the purchased item.
	 * If this item is for discounts or shipping cost, the id can be 0.
	 *
	 * @return string|int
	 */
	public function getProductId();

	/**
	 * The quantity of the item included in the order.
	 *
	 * @return int the quantity.
	 */
	public function getQuantity();

	/**
	 * The name of the item included in the order.
	 *
	 * @return string the name.
	 */
	public function getName();

	/**
	 * The unit price of the item included in the order, formatted according to "99.99".
	 *
	 * @return float the unit price.
	 */
	public function getUnitPrice();

	/**
	 * The 3-letter ISO code (ISO 4217) for the currency the item was purchased in.
	 *
	 * @return string the currency ISO code.
	 */
	public function getCurrencyCode();
}
