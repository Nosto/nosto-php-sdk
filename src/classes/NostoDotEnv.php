<?php

/**
 * Helper class for loading local environment variables and assigning them to $_ENV.
 * Based on https://github.com/vlucas/phpdotenv
 */
class NostoDotEnv
{
	/**
	 * @var NostoDotEnv the runtime cache for the class instance.
	 */
	private static $_instance;

	/**
	 * Constructor.
	 * Private; Singleton pattern.
	 */
	private function __construct()
	{
	}

	/**
	 * Getter for the singleton instance.
	 *
	 * @return NostoDotEnv the singleton instance.
	 */
	public static function getInstance()
	{
		if (self::$_instance === null) {
			self::$_instance = new NostoDotEnv();
		}
		return self::$_instance;
	}

	/**
	 * Initializes the environment variables from ".env" if it exists.
	 *
	 * @param string $path the path where to find the ".env" file.
	 * @param string $fileName the name of the file; defaults to ".env".
	 */
	public function init($path, $fileName = '.env')
	{
		$file = (!empty($path) ? rtrim($path, '/') . '/' : '') . $fileName;
		if (is_file($file) && is_readable($file)) {
			foreach ($this->parseFile($file) as $line) {
				$this->setEnvVariable($line);
			}
		}
	}

	/**
	 * Parses the ".env" file into lines and returns them as an array.
	 *
	 * @param string $file the path of the file to parse.
	 * @return array the parsed lines from the file.
	 */
	protected function parseFile($file)
	{
		$autodetect = ini_get('auto_detect_line_endings');
		ini_set('auto_detect_line_endings', '1');
		$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		ini_set('auto_detect_line_endings', $autodetect);
		return is_array($lines) ? $lines : array();
	}

	/**
	 * Sets a non-existent variable in $_ENV.
	 *
	 * @param string $var the environment variable to set.
	 */
	protected function setEnvVariable($var)
	{
		if (strpos(trim($var), '#') !== 0 && strpos($var, '=') !== false) {
			list($name, $value) = $this->normalizeEnvVariable($var);
			if (!isset($_ENV[$name])) {
				$_ENV[$name] = $value;
			}
		}
	}

	/**
	 * Normalizes the given variable into a variable name and value.
	 *
	 * @param string $var the variable to normalize.
	 * @return array the variable name and value as an array.
	 */
	protected function normalizeEnvVariable($var)
	{
		list($name, $value) = array_map('trim', explode('=', $var, 2));
		$name = $this->sanitizeVariableName($name);
		$value = $this->sanitizeVariableValue($value);
		$value = $this->resolveNestedVariables($value);
		return array($name, $value);
	}

	/**
	 * Sanitizes the variable value, i.e. strips quotes.
	 *
	 * @param string $value the variable value to sanitize.
	 * @return string the sanitized value.
	 */
	protected function sanitizeVariableValue($value)
	{
		$value = trim($value);
		if (!$value) return '';
		if (strpbrk($value[0], '"\'') !== false) { // value starts with a quote
			$quote = $value[0];
			$regexPattern = sprintf('/^
				%1$s          # match a quote at the start of the value
				(             # capturing sub-pattern used
				 (?:          # we do not need to capture this
				  [^%1$s\\\\] # any character other than a quote or backslash
				  |\\\\\\\\   # or two backslashes together
				  |\\\\%1$s   # or an escaped quote e.g \"
				 )*           # as many characters that match the previous rules
				)             # end of the capturing sub-pattern
				%1$s          # and the closing quote
				.*$           # and discard any string after the closing quote
				/mx', $quote);
			$value = preg_replace($regexPattern, '$1', $value);
			$value = str_replace("\\$quote", $quote, $value);
			$value = str_replace('\\\\', '\\', $value);
		} else {
			$parts = explode(' #', $value, 2);
			$value = $parts[0];
		}
		return trim($value);
	}

	/**
	 * Sanitizes the variable name, i.e. strips quotes.
	 *
	 * @param string $name the variable name to sanitize.
	 * @return string the sanitized name.
	 */
	protected function sanitizeVariableName($name)
	{
		return trim(str_replace(array('\'', '"'), '', $name));
	}

	/**
	 * Look for {$name} patterns in the variable value and replace with an existing environment variable.
	 *
	 * @param string $value the variable value to search for nested variables.
	 * @return string the resolved variable value.
	 */
	protected function resolveNestedVariables($value)
	{
		if (strpos($value, '$') !== false) {
			$value = preg_replace_callback('/{\$([a-zA-Z0-9_]+)}/', array($this, 'getMatchedVariable'), $value);
		}
		return $value;
	}

	/**
	 * Callback for getting the matched variable value.
	 *
	 * @param array $match the match from preg_replace_callback().
	 * @return mixed the matched variable value or the variable name if not found.
	 */
	protected function getMatchedVariable($match)
	{
		return isset($_ENV[$match[1]]) ? $_ENV[$match[1]] : $match[0];
	}
}
