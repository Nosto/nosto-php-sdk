<?php

/** @noinspection PhpUndefinedClassInspection */
class UriTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests a set of valid URis.
     */
    public function testValidUris()
    {
        $this->specify('"http://example.com" is considered valid', function () {
            $this->assertTrue(NostoUri::check('http://example.com'));
        });
        $this->specify('"https://example.com" is considered valid', function () {
            $this->assertTrue(NostoUri::check('https://example.com'));
        });

        $this->specify('"http://example.com/?nostodebug=true" is considered valid', function () {
            $this->assertTrue(NostoUri::check('http://example.com/?nostodebug=true'));
        });
        $this->specify('"https://example.com/?nostodebug=true" is considered valid', function () {
            $this->assertTrue(NostoUri::check('https://example.com/?nostodebug=true'));
        });

        $this->specify('"http://example.com/catalog?nostodebug=true" is considered valid', function () {
            $this->assertTrue(NostoUri::check('http://example.com/catalog?nostodebug=true'));
        });
        $this->specify('"https://example.com/catalog?nostodebug=true" is considered valid', function () {
            $this->assertTrue(NostoUri::check('https://example.com/catalog?nostodebug=true'));
        });

        $this->specify('"http://example.com/index.html" is considered valid', function () {
            $this->assertTrue(NostoUri::check('http://example.com/index.html'));
        });
        $this->specify('"https://example.com/index.html" is considered valid', function () {
            $this->assertTrue(NostoUri::check('https://example.com/index.html'));
        });

        $this->specify('"http://example.com/index.html?nostodebug=true" is considered valid', function () {
            $this->assertTrue(NostoUri::check('http://example.com/index.html?nostodebug=true'));
        });
        $this->specify('"https://example.com/index.html?nostodebug=true" is considered valid', function () {
            $this->assertTrue(NostoUri::check('https://example.com/index.html?nostodebug=true'));
        });
    }

    /**
     * Tests a set of invalid URis.
     */
    public function testInvalidUris()
    {
        $this->specify('"http://example.com?nostodebug=true" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('http://example.com?nostodebug=true'));
        });
        $this->specify('"https://example.com?nostodebug=true" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('https://example.com?nostodebug=true'));
        });

        $this->specify('"example.com" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('example.com'));
        });
        $this->specify('"www.example.com" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('www.example.com'));
        });
        $this->specify('"ftp://example.com" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('ftp://example.com'));
        });
        $this->specify('"ssh://example.com" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('ssh://example.com'));
        });
        $this->specify('"//example.com" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('//example.com'));
        });

        $this->specify('"example.com?nostodebug=true" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('example.com?nostodebug=true'));
        });
        $this->specify('"example.com/index.html" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('example.com/index.html'));
        });
        $this->specify('"example.com/index.html?nostodebug=true" is considered invalid', function () {
            $this->assertFalse(NostoUri::check('example.com/index.html?nostodebug=true'));
        });
    }
}
