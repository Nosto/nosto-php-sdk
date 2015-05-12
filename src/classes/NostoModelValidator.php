<?php
/**
 * Copyright (c) 2015, Nosto Solutions Ltd
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
 * @copyright 2015 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 */

/**
 * Model validator util that is used to validate `validatable` models.
 */
class NostoModelValidator
{
    /**
     * Validates the `validatable` model based opn it's validation rules.
     *
     * @param NostoValidatableModelInterface $model the model to validate.
     * @return bool true if the model is valid, false otherwise.
     * @throws NostoException if the rule validator is not found.
     */
    public function validate(NostoValidatableModelInterface $model)
    {
        foreach ($model->getValidationRules() as $rule) {
            if (isset($rule[0], $rule[1])) {
                $properties = $rule[0];
                $validator = 'validate'.$rule[1];
                if (!method_exists($this, $validator)) {
                    throw new NostoException(sprintf('Nosto validator "%s" does not exist.', $validator));
                }
                $isValid = call_user_func(array($this, $validator), $model, $properties);
                if (!$isValid) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Validates that all the given properties are NOT empty in this instance.
     *
     * @param NostoValidatableModelInterface $model the model to validate the properties on.
     * @param array $properties the list of property names to validate.
     * @return bool true if all are valid, false otherwise.
     */
    protected function validateRequired(NostoValidatableModelInterface $model, array $properties)
    {
        foreach ($properties as $property) {
            // Prefer property getter if available.
            // Strip any "_" character at beginning of property name.
            $getter = 'get'.trim($property, '_');
            if (method_exists($model, $getter)) {
                $value = $model->{$getter}();
                if (empty($value)) {
                    return false;
                }
            } elseif (empty($model->{$property})) {
                return false;
            }
        }
        return true;
    }
}
