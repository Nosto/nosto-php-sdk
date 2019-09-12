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

namespace Nosto\Test\Support;

use Nosto\Object\Product\Variation;
use Nosto\Object\Product\VariationCollection;

class MockVariationCollection extends VariationCollection
{
    public function __construct()
    {
        $variation1 = new Variation();
        $variation1->setVariationId('USD_1');
        $variation1->setPrice(99.99);
        $variation1->setListPrice(110.99);
        $variation1->setPriceCurrencyCode('USD');
        $variation1->setAvailability('InStock');
        $this->append($variation1);
        $variation2 = new Variation();
        $variation2->setVariationId('EUR_2');
        $variation2->setPrice(69.99);
        $variation2->setListPrice(99.99);
        $variation2->setPriceCurrencyCode('EUR');
        $variation2->setAvailability('InStock');
        $this->append($variation2);
        $variation3 = new Variation();
        $variation3->setVariationId('SEK_3');
        $variation3->setPrice(990.99);
        $variation3->setListPrice(1100.99);
        $variation3->setPriceCurrencyCode('SEK');
        $variation3->setAvailability('OutOfStock');
        $this->append($variation3);
    }
}
