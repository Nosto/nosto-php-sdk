<?php

/**
 * Interface for the account owner details.
 * This is used by the NostoAccountMetaDataInterface meta data model when creating new Nosto accounts.
 */
interface NostoAccountMetaDataOwnerInterface
{
	/**
	 * The first name of the account owner.
	 *
	 * @return string the first name.
	 */
	public function getFirstName();

	/**
	 * The last name of the account owner.
	 *
	 * @return string the last name.
	 */
	public function getLastName();

	/**
	 * The email address of the account owner.
	 *
	 * @return string the email address.
	 */
	public function getEmail();
}
