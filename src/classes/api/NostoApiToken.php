<?php

/**
 * Class representing an API token for the Nosto API's.
 */
class NostoApiToken
{
	/**
	 * @var string the token name, must be one of the defined tokens from self::$tokenNames.
	 */
	public $name;

	/**
	 * @var string the token value, e.g. the actual token string.
	 */
	public $value;

	/**
	 * @var array list of valid api tokens to request from Nosto.
	 */
	public static $tokenNames = array(
		'sso',
		'products'
	);

	/**
	 * Parses a list of token name=>value pairs and creates token instances of them.
	 *
	 * @param array $tokens the list of token name=>value pairs.
	 * @param string $prefix optional prefix for the token name in the list.
	 * @param string $postfix optional postfix for the token name in the list.
	 * @return NostoApiToken[] a list of token instances.
	 */
	public static function parseTokens(array $tokens, $prefix = '', $postfix = '')
	{
		$parsedTokens = array();
		foreach (self::$tokenNames as $name) {
			$key = $prefix.$name.$postfix;
			if (isset($tokens[$key])) {
				$token = new self();
				$token->name = $name;
				$token->value = $tokens[$key];
				$parsedTokens[$name] = $token;
			}
		}
		return $parsedTokens;
	}
}
