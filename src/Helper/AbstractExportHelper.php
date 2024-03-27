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

use Nosto\Types\Signup\AccountInterface;
use phpseclib3\Crypt\Hash;

/**
 * Helper class for exporting historical product and OrderConfirm data from the shop. This
 * information is used to bootstrap recommendations and decreases the time needed to
 * get accurate recommendations showing in the shop without the learning period.
 */
abstract class AbstractExportHelper
{
    /**
     * Serializes the collection to JSON and uses the SSO token (as it is pre-shared
     * secret) to encrypt the data using AES. 12 random characters are used as
     * the IV and must be extracted out from the resultant payload before decrypting
     *
     * @param AccountInterface $account the account to export the data for
     * @param mixed $collection the data collection to export
     * @return string the AES encrypted data.
     */
    public function export(AccountInterface $account, $collection)
    {
        $data = '';
        $token = $account->getApiToken('sso');
        if ($token !== null) {
            $hash = new Hash('sha3-256');
            $secret = $hash->hash(base64_decode($token->getValue()));
            if (!empty($secret)) {
                $data = $this->encrypt($secret, $collection);
            }
        }
        return $data;
    }

    /**
     * Method for encrypting the data
     *
     * @param string $secret
     * @param mixed $data
     * @return string
     */
    abstract public function encrypt(string $secret, $data);
}
