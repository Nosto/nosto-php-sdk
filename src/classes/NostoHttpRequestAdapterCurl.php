<?php

/**
 * Adapter class for making http requests using curl.
 * This adapter requires curl to be installed.
 */
class NostoHttpRequestAdapterCurl extends NostoHttpRequestAdapter
{
	/**
	 * @inheritdoc
	 */
	public function get($url, array $options = array())
	{
		$this->init($options);
		return $this->send(array(
			CURLOPT_URL => $url,
			CURLOPT_HEADER => 1,
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 60,
		));
	}

	/**
	 * @inheritdoc
	 */
	public function post($url, array $options = array())
	{
		$this->init($options);
		return $this->send(array(
			CURLOPT_URL => $url,
			CURLOPT_POSTFIELDS => $this->content,
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 1,
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 60,
		));
	}

	/**
	 * Sends the request and creates a NostoHttpResponse instance containing the response headers and body.
	 *
	 * @param array $curl_options options for curl_setopt_array().
	 * @return NostoHttpResponse
	 */
	protected function send(array $curl_options)
	{
		if (!empty($this->headers))
			$curl_options[CURLOPT_HTTPHEADER] = $this->headers;
		$ch = curl_init();
		curl_setopt_array($ch, $curl_options);
		$result = curl_exec($ch);
		$response = new NostoHttpResponse();
		if ($result !== false)
		{
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$header = substr($result, 0, $header_size);
			$header = explode("\r\n", $header);
			$body = substr($result, $header_size);
			if (!empty($header))
				$response->setHeaders($header);
			$response->setResult($body);
		}
		else
		{
			$response->setMessage(curl_error($ch));
		}
		curl_close($ch);
		return $response;
	}
}
