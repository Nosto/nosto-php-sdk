<?php

interface NostoAccountInterface
{
	/**
	 * @param NostoAccountMetaDataInterface $meta
	 * @return NostoAccount
	 * @throws NostoException
	 */
	public static function create(NostoAccountMetaDataInterface $meta);

	/**
	 * @param NostoOAuthClientMetaDataInterface $meta
	 * @param string $code
	 * @return NostoAccount
	 * @throws NostoException
	 */
	public static function syncFromNosto(NostoOAuthClientMetaDataInterface $meta, $code);

	/**
	 * @return bool
	 */
	public function isConnectedToNosto();
} 