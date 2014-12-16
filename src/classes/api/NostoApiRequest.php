<?php

/**
 * API request class for making API requests to Nosto.
 */
class NostoApiRequest extends NostoHttpRequest
{
	const PATH_ORDER_TAGGING = '/visits/order/confirm/{m}/{cid}';
	const PATH_UNMATCHED_ORDER_TAGGING = '/visits/order/unmatched/{m}';
	const PATH_SIGN_UP = '/accounts/create/{lang}';
	const PATH_SSO_AUTH = '/users/sso/{email}';
	const PATH_PRODUCT_RE_CRAWL = '/products/recrawl';

	const TOKEN_SIGN_UP = 'JRtgvoZLMl4NPqO9XWhRdvxkTMtN82ITTJij8U7necieJPCvjtZjm5C4fpNrYJ81';

	/**
	 * @var string base url for the nosto api.
	 */
	public static $baseUrl = 'https://api.nosto.com';

	/**
	 * Setter for the end point path, e.g. one of the PATH_ constants.
	 * The API base url is always prepended.
	 *
	 * @param string $path the endpoint path (use PATH_ constants).
	 */
	public function setPath($path)
	{
		$this->setUrl(self::$baseUrl.$path);
	}
}
