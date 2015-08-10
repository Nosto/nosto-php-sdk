<?php

class CountryTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests that invalid country codes cannot be created.
     */
    public function testInvalidCountryCode()
    {
        $this->setExpectedException('NostoInvalidArgumentException');

        new NostoCountryCode('us');
    }

    /**
     * Tests that valid country codes can be created.
     */
    public function testValidCountryCode()
    {
        $countryCode = new NostoCountryCode('US');

        $this->specify('country code is US', function() use ($countryCode) {
                $this->assertTrue($countryCode->getCode() === "US");
            });
    }
}
