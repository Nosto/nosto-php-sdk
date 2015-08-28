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
                $this->assertTrue($price->getPrice() === 1);
            });

        $price = new NostoPrice('1.667');
        $this->specify('price is 1.667', function() use ($price) {
                $this->assertTrue($price->getPrice() === '1.667');
            });

        $price = new NostoPrice(1.667);
        $this->specify('price is 1.667', function() use ($price) {
                $this->assertTrue($price->getPrice() === 1.667);
            });

        $price = new NostoPrice('0.99');
        $this->specify('price is 0.99', function() use ($price) {
                $this->assertTrue($price->getPrice() === '0.99');
            });

        $price = new NostoPrice(0.99);
        $this->specify('price is 0.99', function() use ($price) {
                $this->assertTrue($price->getPrice() === 0.99);
            });

        $price = new NostoPrice(5.00);
        $price = $price->multiply(1.14787);
        $this->specify('price is 5.73935', function() use ($price) {
                $this->assertTrue($price->getPrice() === 5.73935);
            });

        $price = new NostoPrice(500, new NostoCurrencyCode("EUR"));
        $price = $price->multiply(1.14787);
        $this->specify('price is 5.74', function() use ($price) {
                $this->assertTrue($price->getRawPrice() === 574);
                $this->assertTrue($price->getPrice() === 5.74);
            });
    }
}
