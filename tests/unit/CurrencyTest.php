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

        $currency = new NostoCurrency($code, $symbol, $symbolPosition, $groupSymbol, $decimalSymbol, $groupLength, $precision);

        $this->specify('currency code is EUR', function() use ($currency, $code) {
                $this->assertTrue($currency->getCode() === $code);
            });

        $this->specify('currency symbol is €', function() use ($currency, $symbol) {
                $this->assertTrue($currency->getSymbol() === $symbol);
            });

        $this->specify('currency symbol position is right', function() use ($currency, $symbolPosition) {
                $this->assertTrue($currency->getSymbolPosition() === $symbolPosition);
            });

        $this->specify('currency group symbol is empty string', function() use ($currency, $groupSymbol) {
                $this->assertTrue($currency->getGroupSymbol() === $groupSymbol);
            });

        $this->specify('currency decimal symbol is dot', function() use ($currency, $decimalSymbol) {
                $this->assertTrue($currency->getDecimalSymbol() === $decimalSymbol);
            });

        $this->specify('currency group length is 3', function() use ($currency, $groupLength) {
                $this->assertTrue($currency->getGroupLength() === $groupLength);
            });

        $this->specify('currency decimal precision is 2', function() use ($currency, $precision) {
                $this->assertTrue($currency->getPrecision() === $precision);
            });
    }
}
