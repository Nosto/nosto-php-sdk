<?php
/**
 * Copyright (c) 2020, Nosto Solutions Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its contributors
 * may be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Nosto Solutions Ltd <contact@nosto.com>
 * @copyright 2020 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Helper;

/**
 * Implementation for the export helper
 */
class ExportHelper extends AbstractExportHelper
{
    /**
     * @inheritdoc
     * @suppress PhanAccessMethodInternal
     */
    public function encrypt($secret, $data)
    {
        //noinspectionstart PhpUndefinedNamespaceInspections, PhpUndefinedClassInspections
        //Check if phpseclib v3 is used
        //needed for comaptibility with Magento 2.4 versions
        if (class_exists("phpseclib3\Crypt\AES")) {
            $iv = \phpseclib3\Crypt\Random::string(16);
            $cipher = new \phpseclib3\Crypt\AES('cbc');
        } else {
            $iv = \phpseclib\Crypt\Random::string(16);                           // @phan-suppress-current-line PhanUndeclaredClassMethod
            $cipher = new \phpseclib\Crypt\AES(\phpseclib\Crypt\Base::MODE_CBC); // @phan-suppress-current-line PhanUndeclaredClassConstant, PhanUndeclaredClassMethod
        }

        $cipher->setKey($secret);                                                      // @phan-suppress-current-line PhanUndeclaredClassMethod
        $cipher->setIV($iv);                                                           // @phan-suppress-current-line PhanUndeclaredClassMethod
        $cipherText = $cipher->encrypt(SerializationHelper::serialize($data));         // @phan-suppress-current-line PhanUndeclaredClassMethod
        //noinspectionend
        // Prepend the IV to the cipher string so that nosto can parse and use it.
        // There is no security concern with sending the IV as plain text.
        $data = $iv . $cipherText;

        return $data;
    }
}
