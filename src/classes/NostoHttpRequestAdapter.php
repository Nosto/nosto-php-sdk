<?php

/**
 * Base class for all http request adapters.
 */
abstract class NostoHttpRequestAdapter
{
	/**
	 * @var array the request headers.
	 */
	protected $headers = array();

	/**
	 * @var mixed the request content.
	 */
	protected $content = null;

	/**
	 * Initializes the request options.
	 *
	 * @param array $options the options.
	 */
	protected function init(array $options = array())
	{
		foreach ($options as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	/**
	 * Does a GET request and returns the http response object.
	 *
	 * @param string $url the URL to request.
	 * @param array $options the request options.
	 * @return NostoHttpResponse the response object.
	 */
	abstract public function get($url, array $options = array());

	/**
	 * Does a POST request and returns the http response object.
	 *
	 * @param string $url the URL to request.
	 * @param array $options the request options.
	 * @return NostoHttpResponse the response object.
	 */
	abstract public function post($url, array $options = array());
}
