<?php

require_once(dirname(__FILE__) . '/../_support/Zend/Exception.php');
require_once(dirname(__FILE__) . '/../_support/Zend/Cache.php');
require_once(dirname(__FILE__) . '/../_support/Zend/Currency.php');
require_once(dirname(__FILE__) . '/../_support/Zend/Locale.php');
require_once(dirname(__FILE__) . '/../_support/Zend/Xml/Exception.php');
require_once(dirname(__FILE__) . '/../_support/Zend/Xml/Security.php');

class CurrencyHelperTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests that the currency helper can parse the zend currency format correctly.
     */
    public function testZendCurrencyFormatParser()
    {
        /** @var NostoHelperCurrency $helper */
        $helper = Nosto::helper('currency');

        $currency = $helper->parseZendCurrencyFormat('USD', new Zend_Currency('USD', 'en_US'));

        $this->specify('zend currency was parsed into a NostoCurrency object', function() use ($currency) {
            $this->assertInstanceOf('NostoCurrency', $currency);
        });
    }
}
