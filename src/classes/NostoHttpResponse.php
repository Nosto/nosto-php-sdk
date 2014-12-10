<?php

/**
 * Represents a http request response returned by NostoHttpRequest.
 */
class NostoHttpResponse
{
	/**
	 * @var array the response headers if there are any.
	 */
	protected $headers;

	/**
	 * @var mixed the request result raw body.
	 */
	protected $result;

	/**
	 * @var string possible request error message.
	 */
	protected $message;

	/**
	 * @param mixed $result
	 */
	public function setResult($result)
	{
		$this->result = $result;
	}

	/**
	 * @return mixed
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * @param string $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}

	/**
	 * @return string
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * @param bool $assoc
	 * @return mixed
	 */
	public function getJsonResult($assoc = false)
	{
		return json_decode($this->result, $assoc);
	}

	/**
	 * @param array $headers
	 */
	public function setHeaders($headers)
	{
		$this->headers = $headers;
	}

	/**
	 * Returns the http response code.
	 *
	 * @return int
	 */
	public function getCode()
	{
		$matches = array();
		if (isset($this->headers) && isset($this->headers[0]))
			preg_match('|HTTP/\d\.\d\s+(\d+)\s+.*|', $this->headers[0], $matches);
		return isset($matches[1]) ? (int)$matches[1] : 0;
	}

	/**
	 * Returns the raw http status string.
	 *
	 * @return string the status string or empty if not set.
	 */
	public function getRawStatus()
	{
		if (isset($this->headers) && isset($this->headers[0]))
			return $this->headers[0];
		return '';
	}
}
