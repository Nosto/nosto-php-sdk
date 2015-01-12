<?php

/**
 * Order collection for historical data exports.
 * Supports only items implementing "NostoOrderInterface".
 */
class NostoExportOrderCollection extends NostoExportCollection
{
	/**
	 * @inheritdoc
	 */
	protected $validItemType = 'NostoOrderInterface';

	/**
	 * @inheritdoc
	 */
	public function getJson()
	{
		$array = array();
		/** @var NostoOrderInterface $item */
		foreach ($this->getArrayCopy() as $item) {
			$data = array(
				'order_number' => $item->getOrderNumber(),
				'created_at' => Nosto::helper('date')->format($item->getCreatedDate()),
				'buyer' => array(
					'first_name' => $item->getBuyerInfo()->getFirstName(),
					'last_name' => $item->getBuyerInfo()->getLastName(),
					'email' => $item->getBuyerInfo()->getEmail(),
				),
				'purchased_items' => array(),
			);
			foreach ($item->getPurchasedItems() as $orderItem) {
				$data['purchased_items'][] = array(
					'product_id' => $orderItem->getProductId(),
					'quantity' => (int)$orderItem->getQuantity(),
					'name' => $orderItem->getName(),
					'unit_price' => Nosto::helper('price')->format($orderItem->getUnitPrice()),
					'price_currency_code' => $orderItem->getCurrencyCode(),
				);
			}
			$array[] = $data;
		}
		return json_encode($array);
	}
}
