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

use Nosto\Model\Iframe;

class MockIframe extends Iframe
{

    public function __construct()
    {
        parent::__construct();
        $this->setPreviewUrlProduct('http://shop.com/products?nostodebug=true');
        $this->setPreviewUrlCategory('http://shop.com/category?nostodebug=true');
        $this->setPreviewUrlSearch('http://shop.com/search?nostodebug=true');
        $this->setPreviewUrlCart('http://shop.com/cart?nostodebug=true');
        $this->setPreviewUrlFront('http://shop.com?nostodebug=true');
        $this->setShopName('Shop Name');
        $this->setModules(array('yotpo', 'klarna'));
        $this->setFirstName('James');
        $this->setLastName('Kirk');
        $this->setEmail('james.kirk@example.com');
        $this->setLanguageIsoCode('en');
        $this->setLanguageIsoCodeShop('en');
        $this->setUniqueId('123');
        $this->setPlatform('platform');
        $this->setVersionPlatform('1.0.0');
        $this->setVersionModule('0.1.0');
    }
}
