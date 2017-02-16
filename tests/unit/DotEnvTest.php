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

class DotEnvTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

	/**
	 * Tests a .env file.
	 */
	public function testDotEnvFile()
    {
		$dotEnv = NostoDotEnv::getInstance();
		$dotEnv->init(__DIR__.'/../_support', '.env-test');

		$this->specify('dot-env variable TEST_VARIABLE assigned to $_ENV', function() {
			$this->assertArrayHasKey('TEST_VARIABLE', $_ENV);
			$this->assertEquals('test', $_ENV['TEST_VARIABLE']);
		});

		$this->specify('dot-env variable TEST_VARIABLE_QUOTED_VALUE assigned to $_ENV', function() {
			$this->assertArrayHasKey('TEST_VARIABLE_QUOTED_VALUE', $_ENV);
			$this->assertEquals('test', $_ENV['TEST_VARIABLE_QUOTED_VALUE']);
		});

		$this->specify('dot-env variable TEST_VARIABLE_NESTED assigned to $_ENV', function() {
			$this->assertArrayHasKey('TEST_VARIABLE_NESTED', $_ENV);
			$this->assertEquals('test/test', $_ENV['TEST_VARIABLE_NESTED']);
		});
    }
}
