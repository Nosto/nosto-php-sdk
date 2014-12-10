<?php

interface NostoAccountMetaDataOwnerInterface
{
	/**
	 * @return string
	 */
	public function getFirstName();

	/**
	 * @return string
	 */
	public function getLastName();

	/**
	 * @return string
	 */
	public function getEmail();
} 