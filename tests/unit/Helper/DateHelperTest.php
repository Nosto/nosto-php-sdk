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

namespace Nosto\Test\Unit\Helper;

use Codeception\Specify;
use Codeception\TestCase\Test;
use Nosto\Helper\DateHelper;

class DateHelperTest extends Test
{
    use Specify;

    /**
     * Tests that the helper formats the date as expected
     */
    public function testHelperFormatting()
    {
        $this->assertEquals('2009-01-31', DateHelper::format('2009-01-31'));
        $this->assertEquals('2016-01-01', DateHelper::format('01.01.2016'));
        $this->assertEquals('1970-01-01', DateHelper::format('01.24.2016'));
        $this->assertEquals('1970-01-01', DateHelper::format(null));
        $this->assertEquals('2013-03-05', DateHelper::format('2013-03-05T08:25:10+02:00'));
        $this->assertEquals('2013-03-05', DateHelper::format('5-3-2013'));
        $this->assertEquals('2015-07-13', DateHelper::format('15-7-13'));
        $this->assertEquals('1970-01-01', DateHelper::format('5-13-2013'));
        $this->assertEquals('1970-01-01', DateHelper::format('15-17-3'));
    }
}
