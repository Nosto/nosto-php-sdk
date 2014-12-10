<?php

require_once(dirname(__FILE__).'/../libs/phpseclib/crypt/NostoCryptBase.php');
require_once(dirname(__FILE__).'/../libs/phpseclib/crypt/NostoCryptRijndael.php');
require_once(dirname(__FILE__).'/../libs/phpseclib/crypt/NostoCryptAES.php');

/**
 * Helper class for encrypting/decrypting strings.
 */
class NostoCipher
{
	/**
	 * @var NostoCryptBase
	 */
	private $_crypt;

	/**
	 * Constructor.
	 */
	public function __construct()
	{
		$this->_crypt = new NostoCryptAES(CRYPT_AES_MODE_CBC);
	}

	/**
	 * Sets the secret to use for encryption/decryption.
	 *
	 * @param string $secret the secret.
	 */
	public function setSecret($secret)
	{
		$this->_crypt->setKey($secret);
	}

	/**
	 * Sets the initialization vector to use for encryption/decryption.
	 *
	 * @param string $iv the initialization vector.
	 */
	public function setIV($iv)
	{
		$this->_crypt->setIV($iv);
	}

	/**
	 * Encrypts the string an returns iv.encrypted.
	 *
	 * @param string $plaintext the string to encrypt.
	 * @return string the encrypted string.
	 */
	public function encrypt($plaintext)
	{
		return $this->_crypt->encrypt($plaintext);
	}

	/**
	 * Decrypts the string and returns the plain text.
	 *
	 * @param string $ciphertext the encrypted cipher.
	 * @return string the decrypted plain text string.
	 */
	public function decrypt($ciphertext)
	{
		return $this->_crypt->decrypt($ciphertext);
	}
}
