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

use stdClass;

class ArrayHelper extends AbstractHelper
{
    /**
     * Check if the array contains only strings or numeric values
     *
     * @param array $array
     * @return bool
     */
    public static function onlyScalarValues(array $array)
    {
        foreach ($array as $elem) {
            if (!is_scalar($elem)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks whether an array is associative or sequentially indexed as associative arrays are
     * handled as objects
     *
     * @param array $arr the array to check
     * @return bool true if the array is associative
     */
    public static function isAssoc(array $arr)
    {
        if ([] === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Converts stdClass to a map
     *
     * @param stdClass $object
     * @return mixed
     */
    public static function stdClassToArray(stdClass $object)
    {
        return json_decode(json_encode($object), true);
    }

    /**
     * Sorts an array by keys recursively
     *
     * @param array $arr
     */
    public static function ksortRecursively(array &$arr)
    {
        ksort($arr);
        foreach ($arr as $key => &$nested) {
            if (is_array($nested)) {
                self::ksortRecursively($nested);
            }
        }
    }
}
