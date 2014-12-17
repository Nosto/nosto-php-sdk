<?php

/**
 * Helper class for exporting historical product and order data from the shop.
 * This information is used to bootstrap recommendations and decreases the time needed to get accurate recommendations
 * showing in the shop.
 */
class NostoExporter
{
	/**
	 * Encrypts and returns the data.
	 *
	 * @param NostoAccountInterface $account the account to export the data for.
	 * @param NostoExportCollection $collection the data collection to export.
	 * @return string the encrypted data.
	 */
	public static function export(NostoAccountInterface $account, NostoExportCollection $collection)
	{
		$data = '';
		// Use the first 16 chars of the SSO token as secret for encryption.
		$token = $account->getApiToken('sso');
		if (!empty($token)) {
			$secret = substr($token->value, 0, 16);
			if (!empty($secret)) {
				$iv = NostoCryptRandom::getRandomString(16);
				$cipher = new NostoCipher();
				$cipher->setSecret($secret);
				$cipher->setIV($iv);
				$cipher_text = $cipher->encrypt($collection->getJson());
				// Prepend the IV to the cipher string so that nosto can parse and use it.
				// There is no security concern with sending the IV as plain text.
				$data = $iv.$cipher_text;
			}
		}
		return $data;
	}
}
