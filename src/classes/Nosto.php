<?php

/**
 * Main SDK class.
 * Provides common functionality for the SDK.
 */
class Nosto
{
	/**
	 * @var array registry collection
	 */
	private static $_registry = array();

	/**
	 * Gets a helper class instance by name.
	 *
	 * @param string $helper the name of the helper class to get.
	 * @return NostoHelper the helper instance.
	 * @throws NostoException if helper cannot be found.
	 */
	public static function helper($helper)
	{
		$registryKey = '__helper__/' . $helper;
		if (!self::registry($registryKey)) {
			$helperClass = self::getHelperClassName($helper);
			if (!class_exists($helperClass)) {
				throw new NostoException(sprintf('Unknown helper class %s', $helperClass));
			}
			self::register($registryKey, new $helperClass);
		}
		return self::registry($registryKey);
	}

	/**
	 * Retrieve a value from registry by a key.
	 *
	 * @param string $key the register key for the variable.
	 * @return mixed the registered variable or null if not found.
	 */
	public static function registry($key)
	{
		if (isset(self::$_registry[$key])) {
			return self::$_registry[$key];
		}
		return null;
	}

	/**
	 * Register a new variable.
	 *
	 * @param string $key the key to register the variable for.
	 * @param mixed $value the variable to register.
	 * @throws NostoException if the key is already registered.
	 */
	public static function register($key, $value)
	{
		if (isset(self::$_registry[$key])) {
			throw new NostoException(sprintf('Nosto registry key %s already exists', $key));
		}
		self::$_registry[$key] = $value;
	}

	/**
	 * Converts a helper class name reference name to a real class name.
	 *
	 * Examples:
	 *
	 * date => NostoHelperDate
	 * price_rule => NostoHelperPriceRule
	 * nosto/date => NostoHelperDate
	 * nosto/price_rule => NostoHelperPriceRule
	 * nosto_tagging/date => NostoTaggingHelperDate
	 * nosto_tagging/price_rule => NostoTaggingHelperPriceRule
	 *
	 * @param string $ref the helper reference name.
	 * @return string|bool the helper class name or false if it cannot be built.
	 */
	protected static function getHelperClassName($ref)
	{
		if (strpos($ref, '/') === false) {
			$ref = 'nosto/' . $ref;
		}
		return str_replace(' ', '', ucwords(str_replace('_', ' ', str_replace('/', ' Helper ', $ref))));
	}
}
