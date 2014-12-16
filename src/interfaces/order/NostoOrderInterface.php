<?php

/**
 * Interface for the meta data of an placed order.
 * This is used when making order confirmation API requests and order history exports to Nosto.
 */
interface NostoOrderInterface
{
	/**
	 * The unique order number identifying the order.
	 *
	 * @return string|int the order number.
	 */
	public function getOrderNumber();

	/**
	 * The date when the order was placed, formatted according to "Y-m-d".
	 *
	 * @return string the creation date.
	 */
	public function getCreatedDate();

	/**
	 * The payment provider used for placing the order, formatted according to "[provider name] [provider version]".
	 *
	 * @return string the payment provider.
	 */
	public function getPaymentProvider();

	/**
	 * The buyer info of the user who placed the order.
	 *
	 * @return NostoOrderBuyerInterface the meta data model.
	 */
	public function getBuyerInfo();

	/**
	 * The purchased items which were included in the order.
	 *
	 * @return NostoOrderPurchasedItemInterface[] the meta data models.
	 */
	public function getPurchasedItems();
}
