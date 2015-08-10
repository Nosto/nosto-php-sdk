<?php

class PriceTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests that invalid prices cannot be created.
     */
    public function testInvalidPrice()
    {
        $this->setExpectedException('NostoInvalidArgumentException');

        new NostoPrice('1a2');
    }

    /**
     * Tests that valid prices can be created.
     */
    public function testValidPrice()
    {
        $price = new NostoPrice('1');

        $this->specify('price is 1', function() use ($price) {
                $this->assertTrue($price->getPrice() === '1');
            });

        $price = new NostoPrice(1);

        $this->specify('price is 1', function() use ($price) {
                $this->assertTrue($price->getPrice() === '1');
            });

        $price = new NostoPrice('1.667');

        $this->specify('price is 1.667', function() use ($price) {
                $this->assertTrue($price->getPrice() === '1.667');
            });

        $price = new NostoPrice(1.667);

        $this->specify('price is 1.667', function() use ($price) {
                $this->assertTrue($price->getPrice() === '1.667');
            });

        $price = new NostoPrice('0.99');

        $this->specify('price is 0.99', function() use ($price) {
                $this->assertTrue($price->getPrice() === '0.99');
            });

        $price = new NostoPrice(0.99);

        $this->specify('price is 0.99', function() use ($price) {
                $this->assertTrue($price->getPrice() === '0.99');
            });
    }
}
