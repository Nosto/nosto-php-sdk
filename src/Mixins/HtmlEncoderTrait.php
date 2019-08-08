<?php
/**
 * Copyright (c) 2019, Nosto Solutions Ltd
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
 * @copyright 2019 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Mixins;

use Nosto\Helper\HtmlMarkupSerializationHelper;
use Nosto\NostoException;
use Nosto\Util\Reflection;

/**
 * Iframe mixin class for account administration iframe.
 */
trait HtmlEncoderTrait
{
    /**
     * @var array
     */
    private $varsToEncode = array();

    /**
     * @var bool
     */
    private $autoEncodeAll = true;

    /**
     * Returns the class variables to encode
     * @return array
     */
    public function varsToEncode()
    {
        if ($this->isAutoEncodeAll() === true) {
            $allClassVariables = array();
            $vars = Reflection::getObjectProperties($this);
            foreach ($vars as $classVar => $val) {
                if (HtmlMarkupSerializationHelper::encodableClassVariable($this, $classVar)) {
                    $allClassVariables[] = $classVar;
                }
            }
            return $allClassVariables;
        } else {
            return $this->varsToEncode;
        }
    }

    /**
     * @param array $varsToEncode
     */
    public function setVarsToEncode(array $varsToEncode)
    {
        $this->varsToEncode = $varsToEncode;
    }

    /**
     * @param $field
     * @throws NostoException
     */
    public function addVarToEncode($field)
    {
        if (!HtmlMarkupSerializationHelper::encodableClassVariable($this, $field)) {
            throw new NostoException(sprintf(
                'Property `%s.%s` is not defined.',
                get_class($this),
                $field
            ));
        }
        $this->varsToEncode[] = $field;
    }

    /**
     * @return void
     * @throws NostoException
     */
    public function htmlEncodeVars()
    {
        foreach ($this->varsToEncode() as $field) {
            if (!HtmlMarkupSerializationHelper::encodableClassVariable($this, $field)) {
                throw new NostoException(sprintf(
                    'Property `%s.%s` is not defined.',
                    get_class($this),
                    $field
                ));
            }
            $getter = 'get' . str_replace('_', '', $field);
            $setter = 'set' . str_replace('_', '', $field);
            $origVal = $this->{$getter}();
            if (HtmlMarkupSerializationHelper::canBeEncoded($origVal)) {
                $encodedVal = HtmlMarkupSerializationHelper::encodeHtmlEntities($origVal);
                $this->{$setter}($encodedVal);
            }
        }
    }

    /**
     * @return bool
     */
    public function isAutoEncodeAll()
    {
        return $this->autoEncodeAll;
    }

    /**
     * Enables all class variables to be encoded
     */
    public function enableAutoEncodeAll()
    {
        $this->autoEncodeAll = true;
    }

    /**
     * Disables all class variables to be encoded
     */
    public function disableAutoEncodeAll()
    {
        $this->autoEncodeAll = false;
    }
}
