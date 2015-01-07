<?php

/**
 * Date helper class for date related tasks.
 */
class NostoHelperDate extends NostoHelper
{
	/**
	 * Formats date into Nosto format, i.e. Y-m-d.
	 *
	 * @param string $date the date string to format (must be a datetime description valid to pass to `strtotime`).
	 * @return string the formatted date.
	 */
	public function format($date)
	{
		return date('Y-m-d', strtotime($date));
	}
}
