<?php
/**
 * Random string generator
 *
 * The idea behind this function is that it can be easily replaced with your own crypt_random_string()
 * function. eg. maybe you have a better source of entropy for creating the initial states or whatever.
 *
 * PHP versions 5
 *
 * Here's a short example of how to use this library:
 * <code>
 * <?php
 *    include NostoCryptRandom.php';
 *
 *    echo bin2hex(NostoCryptRandom::getRandomString(16));
 * ?>
 * </code>
 *
 * LICENSE: Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  Crypt
 * @package   Crypt_Random
 * @author    Jim Wigginton <terrafrost@php.net>
 * @copyright 2007 Jim Wigginton
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      http://phpseclib.sourceforge.net
 */

/**
 * Class representation of the original phpseclib implementation with a few modifications:
 *
 * - additional error checking
 * - openssl_random_pseudo_bytes() output is required to be cryptographically strong
 * - mcrypt_create_iv() is preferred method on Linux
 * - Only AES cipher is available when generating pure-PHP CSPRNG
 */
class NostoCryptRandom
{
    /**
     * Returns a cryptographically string random string.
     *
     * @param int $length the length of the string to generate.
     * @return string the generated random string.
     * @throws NostoException
     */
    public static function getRandomString($length)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            /*
             * Prior to PHP 5.3 this would call rand() on win, hence the function_exists('class_alias') call.
             * Function class_alias was introduced in PHP 5.3.
             */
            if (function_exists('mcrypt_create_iv') && function_exists('class_alias')) {
                $rnd = mcrypt_create_iv($length);
                if ($rnd !== false) {
                    return $rnd;
                }
            }
            /*
             * Function openssl_random_pseudo_bytes was introduced in PHP 5.3.0 but prior to PHP 5.3.4 there was a
             * "possible blocking behavior". As of 5.3.4 openssl_random_pseudo_bytes and mcrypt_create_iv do the exact
             * same thing on Windows. ie. they both call php_win32_get_random_bytes().
             *
             * @link http://php.net/ChangeLog-5.php#5.3.4
             * @link https://github.com/php/php-src/blob/7014a0eb6d1611151a286c0ff4f2238f92c120d6/ext/openssl/openssl.c#L5008
             * @link https://github.com/php/php-src/blob/7014a0eb6d1611151a286c0ff4f2238f92c120d6/ext/mcrypt/mcrypt.c#L1392
             * @link https://github.com/php/php-src/blob/7014a0eb6d1611151a286c0ff4f2238f92c120d6/win32/winutil.c#L80
             */
            if (function_exists('openssl_random_pseudo_bytes') && version_compare(PHP_VERSION, '5.3.4', '>=')) {
                $strong = null;
                $rnd = openssl_random_pseudo_bytes($length, $strong);
                if ($strong) {
                    return $rnd;
                }
            }
        } else {
            if (function_exists('mcrypt_create_iv')) {
                $rnd = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
                if ($rnd !== false) {
                    return $rnd;
                }
            }
            if (function_exists('openssl_random_pseudo_bytes')) {
                $strong = null;
                $rnd = openssl_random_pseudo_bytes($length, $strong);
                if ($strong) {
                    return $rnd;
                }
            }
            if (file_exists('/dev/urandom') && is_readable('/dev/urandom')) {
                if (($fp = @fopen('/dev/urandom', 'rb')) !== false) {
                    if (function_exists('stream_set_read_buffer')) {
                        stream_set_read_buffer($fp, 0);
                    }
                    $rnd = fread($fp, $length);
                    fclose($fp);
                    if ($rnd !== false) {
                        return $rnd;
                    }
                }
            }
        }
        /*
         * The latter part is removed for accessing superglobals directly is
         * deprecated by many frameworks.
         */
        throw new NostoException(
            'Cannot create random string. No functions available.'
        );
    }
}
