<?php

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
	 * @var array list of api tokens to request from Nosto.
	 */
	public static $tokenNames = array(
		'sso',
		'products'
	);

	/**
	 * @param array $tokens
	 * @param string $prefix
	 * @param string $postfix
	 * @return NostoApiToken[]
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
