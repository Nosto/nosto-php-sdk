<?php

/**
 * Handles sending the order confirmations to Nosto via the API.
 *
 * Order confirmations can be sent two different ways:
 * - matched orders; where we know the Nosto customer ID of the user who placed the order
 * - un-matched orders: where we do not know the Nosto customer ID of the user who placed the order
 *
 * The second option is a fallback and should be avoided as much as possible.
 */
class NostoOrderConfirmation
{
	/**
	 * Sends the order confirmation to Nosto.
	 *
	 * @param NostoOrderInterface $order the placed order model.
	 * @param NostoAccountInterface $account the Nosto account for the shop where the order was placed.
	 * @param null $customerId the Nosto customer ID of the user who placed the order.
	 * @throws NostoException on failure.
	 * @return true on success.
	 */
	public static function send(NostoOrderInterface $order, NostoAccountInterface $account, $customerId = null)
	{
		if (!empty($customerId)) {
			$path = NostoApiRequest::PATH_ORDER_TAGGING;
			$replaceParams = array('{m}' => $account->getName(), '{cid}' => $customerId);
		} else {
			$path = NostoApiRequest::PATH_UNMATCHED_ORDER_TAGGING;
			$replaceParams = array('{m}' => $account->getName());
		}
		$request = new NostoApiRequest();
		$request->setPath($path);
		$request->setContentType('application/json');
		$request->setReplaceParams($replaceParams);

		// todo: format date/price.

		$orderData = array(
			'order_number' => $order->getOrderNumber(),
			'buyer' => array(
				'first_name' => $order->getBuyerInfo()->getFirstName(),
				'last_name' => $order->getBuyerInfo()->getLastName(),
				'email' => $order->getBuyerInfo()->getEmail(),
			),
			'created_at' => $order->getCreatedDate(),
			'payment_provider' => $order->getPaymentProvider(),
			'purchased_items' => array(),
		);
		foreach ($order->getPurchasedItems() as $item) {
			$orderData['purchased_items'][] = array(
				'product_id' => $item->getProductId(),
				'quantity' => $item->getQuantity(),
				'name' => $item->getName(),
				'unit_price' => $item->getUnitPrice(),
				'price_currency_code' => $item->getCurrencyCode(),
			);
		}
		$response = $request->post(json_encode($orderData));
		if ($response->getCode() !== 200) {
			throw new NostoException('Failed to send order confirmation to Nosto');
		}
		return true;
	}
}
