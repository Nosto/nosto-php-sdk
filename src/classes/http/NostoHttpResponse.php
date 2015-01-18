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
	 * Setter for the request response data.
	 *
	 * @param mixed $result the response data of the request.
	 */
	public function setResult($result)
	{
		$this->result = $result;
	}

	/**
	 * Getter for the request response data.
	 *
	 * @return mixed the request response data.
	 */
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * Setter for the error message of the request.
	 *
	 * @param string $message the message.
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}

	/**
	 * Getter for the error message of the request.
	 *
	 * @return string the message.
	 */
	public function getMessage()
	{
		return $this->message;
	}

	/**
	 * Getter for the request response as JSON.
	 *
	 * @param bool $assoc if the returned JSON should be formatted as an associative array or an stdClass instance.
	 * @return array|stdClass
	 */
	public function getJsonResult($assoc = false)
	{
		return json_decode($this->result, $assoc);
	}

	/**
	 * Setter for the request response headers.
	 *
	 * @param array $headers the headers,
	 */
	public function setHeaders($headers)
	{
		$this->headers = $headers;
	}

	/**
	 * Returns the http request response code.
	 *
	 * @return int the http code or 0 if not set.
	 */
	public function getCode()
	{
		$matches = array();
		if (isset($this->headers) && isset($this->headers[0]))
			preg_match('|HTTP/\d\.\d\s+(\d+)\s+.*|', $this->headers[0], $matches);
		return isset($matches[1]) ? (int)$matches[1] : 0;
	}

	/**
	 * Returns the raw http request response status string.
	 *
	 * @return string the status string or empty if not set.
	 */
	public function getRawStatus()
	{
		return (isset($this->headers) && isset($this->headers[0])) ? $this->headers[0] : '';
	}
}
