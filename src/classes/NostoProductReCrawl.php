<?php

/**
 * Handles product re-crawl requests to Nosto via the API.
 */
class NostoProductReCrawl
{
	/**
	 * Sends a product re-crawl request to nosto.
	 *
	 * @param NostoProductInterface $product the product to re-crawl.
	 * @param NostoAccountInterface $account the account to re-crawl the product for.
	 * @return bool true on success, false otherwise.
	 * @throws NostoException if the request fails.
	 */
	public static function send(NostoProductInterface $product, NostoAccountInterface $account)
	{
		$token = $account->getApiToken('products');
		if ($token === null) {
			return false;
		}
		$request = new NostoApiRequest();
		$request->setPath(NostoApiRequest::PATH_PRODUCT_RE_CRAWL);
		$request->setContentType('application/json');
		$request->setAuthBasic('', $token->value);
		$response = $request->post(json_encode(array('product_ids' => array($product->getProductId()))));
		if ($response->getCode() !== 200) {
			throw new NostoException('Failed to send product re-crawl to Nosto');
		}
		return true;
	}
}
