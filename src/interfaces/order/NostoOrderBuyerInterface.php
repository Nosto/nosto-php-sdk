<?php

/**
 * Interface for user information meta data of an order.
 * This is used by the NostoOrderInterface meta data model when sending order confirmation API requests.
 */
interface NostoOrderBuyerInterface
{
	/**
	 * Gets the first name of the user who placed the order.
	 *
	 * @return string the first name.
	 */
	public function getFirstName();

	/**
	 * Gets the last name of the user who placed the order.
	 *
	 * @return string the last name.
	 */
	public function getLastName();

	/**
	 * Gets the email address of the user who placed the order.
	 *
	 * @return string the email address.
	 */
	public function getEmail();
}
