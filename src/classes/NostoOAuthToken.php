<?php

/**
 * Helper class that represents a oauth2 access token.
 */
class NostoOAuthToken
{
	/**
	 * @var string the access token string.
	 */
	public $accessToken;

	/**
	 * @var string the merchant name string.
	 */
	public $merchantName;

	/**
	 * @var string the type of token, e.g. "bearer".
	 */
	public $tokenType;

	/**
	 * @var int the amount of time this token is valid for.
	 */
	public $expiresIn;

	/**
	 * Creates a new token instance and populates it with the given data.
	 *
	 * @param array $data the data to put in the token.
	 * @return NostoOAuthToken
	 */
	public static function create(array $data)
	{
		$token = new self();
		foreach ($data as $key => $value) {
			$key = self::underscore2CamelCase($key);
			if (property_exists($token, $key)) {
				$token->{$key} = $value;
			}
		}
		return $token;
	}

	/**
	 * Converts string from underscore format to camel case format, e.g. variable_name => variableName.
	 *
	 * @param string $str the underscore formatted string to convert.
	 * @return string the converted string.
	 */
	protected static function underscore2CamelCase($str)
	{
		// Non-alpha and non-numeric characters become spaces.
		$str = preg_replace('/[^a-z0-9]+/i', ' ', $str);
		// Uppercase the first character of each word.
		$str = ucwords(trim($str));
		// Remove all spaces.
		$str = str_replace(" ", "", $str);
		// Lowercase the first character of the result.
		$str = lcfirst($str);

		return $str;
	}
}
