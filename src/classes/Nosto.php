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
			$helperClass = 'NostoHelper' . ucfirst($helper);
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
}
