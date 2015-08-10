<?php

class LanguageTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests that invalid language codes cannot be created.
     */
    public function testInvalidLanguageCode()
    {
        $this->setExpectedException('NostoInvalidArgumentException');

        new NostoLanguageCode('EN');
    }

    /**
     * Tests that valid language codes can be created.
     */
    public function testValidLanguageCode()
    {
        $langCode = new NostoLanguageCode('en');

        $this->specify('language code is en', function() use ($langCode) {
                $this->assertTrue($langCode->getCode() === "en");
            });
    }
}
