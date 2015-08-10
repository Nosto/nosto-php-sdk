<?php

class CurrencyTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests the currency object.
     */
    public function testCurrency()
    {
        $code = 'EUR';
        $symbol = '€';
        $symbolPosition = 'right';
        $groupSymbol = ' ';
        $decimalSymbol = '.';
        $groupLength = 3;
        $precision = 2;

        $currency = new NostoCurrency(
            new NostoCurrencyCode($code),
            new NostoCurrencySymbol($symbol, $symbolPosition),
            new NostoCurrencyFormat($groupSymbol, $groupLength, $decimalSymbol, $precision)
        );

        $this->specify('currency code is EUR', function() use ($currency, $code) {
                $this->assertTrue($currency->getCode()->getCode() === $code);
            });

        $this->specify('currency symbol is €', function() use ($currency, $symbol) {
                $this->assertTrue($currency->getSymbol()->getSymbol() === $symbol);
            });

        $this->specify('currency symbol position is right', function() use ($currency, $symbolPosition) {
                $this->assertTrue($currency->getSymbol()->getPosition() === $symbolPosition);
            });

        $this->specify('currency group symbol is empty string', function() use ($currency, $groupSymbol) {
                $this->assertTrue($currency->getFormat()->getGroupSymbol() === $groupSymbol);
            });

        $this->specify('currency decimal symbol is dot', function() use ($currency, $decimalSymbol) {
                $this->assertTrue($currency->getFormat()->getDecimalSymbol() === $decimalSymbol);
            });

        $this->specify('currency group length is 3', function() use ($currency, $groupLength) {
                $this->assertTrue($currency->getFormat()->getGroupLength() === $groupLength);
            });

        $this->specify('currency decimal precision is 2', function() use ($currency, $precision) {
                $this->assertTrue($currency->getFormat()->getPrecision() === $precision);
            });
    }

    /**
     * Tests that invalid currency codes cannot be created.
     */
    public function testInvalidCurrencyCode()
    {
        $this->setExpectedException('NostoInvalidArgumentException');

        new NostoCurrencyCode('eur');
    }

    /**
     * Tests that valid currency codes can be created.
     */
    public function testValidCurrencyCode()
    {
        $currencyCode = new NostoCurrencyCode('EUR');

        $this->specify('currency code is EUR', function() use ($currencyCode) {
                $this->assertTrue($currencyCode->getCode() === "EUR");
            });
    }
}
