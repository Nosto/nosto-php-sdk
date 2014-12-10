<?php

/**
 * Adapter class for making http requests using php sockets.
 * This adapter uses file_get_contents() and stream_context_create() for creating http requests.
 *
 * Note that if php is compiled with "--with-curlwrappers" then headers are not sent properly in older php versions.
 * @link https://bugs.php.net/bug.php?id=55438
 */
class NostoHttpRequestAdapterSocket extends NostoHttpRequestAdapter
{
	/**
	 * @inheritdoc
	 */
	public function get($url, array $options = array())
	{
		$this->init($options);
		return $this->send($url, array(
			'http' => array(
				'method' => 'GET',
				'header' => implode("\r\n", $this->headers),
				// Fetch the content even on failure status codes.
				'ignore_errors' => true,
			),
		));
	}

	/**
	 * @inheritdoc
	 */
	public function post($url, array $options = array())
	{
		$this->init($options);
		return $this->send($url, array(
			'http' => array(
				'method' => 'POST',
				'header' => implode("\r\n", $this->headers),
				'content' => $this->content,
				// Fetch the content even on failure status codes.
				'ignore_errors' => true,
			),
		));
	}

	/**
	 * Sends the request and creates a NostoHttpResponse instance containing the response headers and body.
	 *
	 * @param string $url the url for the request.
	 * @param array $stream_options options for stream_context_create().
	 * @return NostoHttpResponse
	 */
	protected function send($url, array $stream_options)
	{
		$context = stream_context_create($stream_options);
		// We use file_get_contents() directly here as we need the http response headers which are automatically
		// populated into $headers, which is only available in the local scope where file_get_contents()
		// is executed (http://php.net/manual/en/reserved.variables.httpresponseheader.php).
		$http_response_header = array();
		$result = file_get_contents($url, false, $context);
		$response = new NostoHttpResponse();
		if (!empty($http_response_header))
			$response->setHeaders($http_response_header);
		$response->setResult($result);
		return $response;
	}
}
