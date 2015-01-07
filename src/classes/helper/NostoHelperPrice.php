<?php

/**
 * Price helper class for price related tasks.
 */
class NostoHelperPrice extends NostoHelper
{
	/**
	 * Formats price into Nosto format, e.g. 1000.99.
	 *
	 * @param string|int|float $price the price string to format.
	 * @return string the formatted price.
	 */
	public function format($price)
	{
		return number_format($price, 2, '.', '');
	}
}
