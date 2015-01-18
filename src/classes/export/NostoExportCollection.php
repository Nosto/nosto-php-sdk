<?php

/**
 * Base class for all export collection classes used for exporting historical data from the shop.
 * The base class provides the functionality to validate the items added to the collection.
 * The collection behaves like an array. making it easy to add items to it and iterate over it.
 */
abstract class NostoExportCollection extends ArrayObject
{
	/**
	 * @var string the type of items this collection can contain.
	 */
	protected $validItemType = '';

	/**
	 * Returns the collection as a JSON string.
	 * In the JSON camel case variables are converted into underscore format.
	 *
	 * @return string the JSON.
	 */
	abstract public function getJson();

	/**
	 * @inheritdoc
	 */
	public function offsetSet($index, $newval)
	{
		$this->validate($newval);
		parent::offsetSet($index, $newval);
	}

	/**
	 * @inheritdoc
	 */
	public function append($value)
	{
		$this->validate($value);
		parent::append($value);
	}

	/**
	 * Validates that the given value is of correct type.
	 *
	 * @see NostoExportCollection::$validItemType
	 * @param mixed $value the value.
	 * @throws NostoException if the value is of invalid type.
	 */
	protected function validate($value)
	{
		if (!is_a($value, $this->validItemType)) {
			$valueType = gettype($value);
			if ($valueType === 'object') {
				$valueType = get_class($value);
			}
			throw new NostoException(sprintf('Collection supports items of type "%s" (type "%s" given)', $this->validItemType, $valueType));
		}
	}
}
