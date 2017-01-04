<?php
/**
 * Copyright (c) 2017, Nosto Solutions Ltd
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
 * @copyright 2017 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

require_once(dirname(__FILE__) . '/../_support/MockNostoProduct.php');
require_once(dirname(__FILE__) . '/../_support/MockNostoOrder.php');

class CollectionTest extends \Codeception\TestCase\Test
{
    /**
     * Tests that the export collection does not accept string items.
     */
    public function testCollectionValidationForString()
    {
        $this->expectException('NostoException');
        $collection = new NostoProductCollection();
        $collection[] = 'invalid item type';
    }

    /**
     * Tests that the export collection does not accept integer items.
     */
    public function testCollectionValidationForInteger()
    {
        $this->expectException('NostoException');
        $collection = new NostoProductCollection();
        $collection->append(1);
    }

    /**
     * Tests that the export collection does not accept float items.
     */
    public function testCollectionValidationForFloat()
    {
        $this->expectException('NostoException');
        $collection = new NostoProductCollection();
        $collection->append(99.99);
    }

    /**
     * Tests that the export collection does not accept array items.
     */
    public function testCollectionValidationForArray()
    {
        $this->expectException('NostoException');
        $collection = new NostoProductCollection();
        $collection[] = array('test');
    }

    /**
     * Tests that the export collection does not accept stdClass items.
     */
    public function testCollectionValidationForObject()
    {
        $this->expectException('NostoException');
        $collection = new NostoProductCollection();
        $collection->append(new stdClass());
    }
}