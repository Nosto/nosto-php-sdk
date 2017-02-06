<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Nosto
 * @package   Nosto_Tagging
 * @author    Nosto Solutions Ltd <magento@nosto.com>
 * @copyright Copyright (c) 2013-2016 Nosto Solutions Ltd (http://www.nosto.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @param $dir
 */

function includeDependencies($dir)
{
    require_once($dir . '/vlucas/phpdotenv/src/Dotenv.php');
    require_once($dir . '/vlucas/phpdotenv/src/Exception/ExceptionInterface.php');
    require_once($dir . '/vlucas/phpdotenv/src/Exception/InvalidCallbackException.php');
    require_once($dir . '/vlucas/phpdotenv/src/Exception/InvalidFileException.php');
    require_once($dir . '/vlucas/phpdotenv/src/Exception/InvalidPathException.php');
    require_once($dir . '/vlucas/phpdotenv/src/Exception/ValidationException.php');
    require_once($dir . '/vlucas/phpdotenv/src/Loader.php');
    require_once($dir . '/vlucas/phpdotenv/src/Validator.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/Base.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/Rijndael.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/AES.php');

    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/Blowfish.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/DES.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/Hash.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/RC2.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/RC4.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/RSA.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/Random.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/TripleDES.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Crypt/Twofish.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/File/ANSI.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/File/ASN1.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/File/ASN1/Element.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/File/X509.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Math/BigInteger.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Net/SCP.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Net/SSH2.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Net/SFTP.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Net/SFTP/Stream.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/Net/SSH1.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/System/SSH/Agent.php');
    require_once($dir . '/phpseclib/phpseclib/phpseclib/System/SSH/Agent/Identity.php');

    require dirname(__FILE__) . '/src/config.inc.php';
    $dotenv = new Dotenv\Dotenv(dirname(__FILE__));
    $dotenv->load();
}
