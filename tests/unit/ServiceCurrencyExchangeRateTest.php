<?php

class ServiceCurrencyExchangeRateTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        // Configure API, Web Hooks, and OAuth client to use Mock server when testing.
        NostoApiRequest::$baseUrl = 'http://localhost:3000';
        NostoOAuthClient::$baseUrl = 'http://localhost:3000';
        NostoHttpRequest::$baseUrl = 'http://localhost:3000';
    }

    /**
     * Tests that the currency exchange rate API request cannot be made without an API token.
     */
    public function testCurrencyExchangeRateUpdateWithoutApiToken()
    {
        $account = new NostoAccount('platform-00000000');

        $collection = new NostoCurrencyExchangeRateCollection();
        $collection->setValidUntil(new NostoDate(time() + (7 * 24 * 60 * 60)));
        $collection[] = new NostoCurrencyExchangeRate(new NostoCurrencyCode('EUR'), '0.706700000000');

        $this->setExpectedException('NostoException');

        $service = new NostoServiceCurrencyExchangeRate($account);
        $service->update($collection);
    }

    /**
     * Tests that the currency exchange rate API request cannot be made without any rates.
     */
    public function testCurrencyExchangeRateUpdateWithoutRates()
    {
        $account = new NostoAccount('platform-00000000');
        $token = new NostoApiToken('rates', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
        $account->addApiToken($token);

        $collection = new NostoCurrencyExchangeRateCollection();
        $collection->setValidUntil(new NostoDate(time() + (7 * 24 * 60 * 60)));

        $this->setExpectedException('NostoException');

        $service = new NostoServiceCurrencyExchangeRate($account);
        $service->update($collection);
    }

    /**
     * Tests that the currency exchange rate API request can be made.
     */
    public function testCurrencyExchangeRateUpdate()
    {
        $account = new NostoAccount('platform-00000000');
        $token = new NostoApiToken('rates', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
        $account->addApiToken($token);

        $collection = new NostoCurrencyExchangeRateCollection();
        $collection->setValidUntil(new NostoDate(time() + (7 * 24 * 60 * 60)));
        $collection[] = new NostoCurrencyExchangeRate(new NostoCurrencyCode('EUR'), '0.706700000000');

        $service = new NostoServiceCurrencyExchangeRate($account);
        $result = $service->update($collection);

        $this->specify('successful currency exchange rate update', function() use ($result) {
                $this->assertTrue($result);
            });
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testHttpFailure()
    {
        NostoApiRequest::$baseUrl = 'http://localhost:1234'; // not a real url

        $account = new NostoAccount('platform-00000000');
        $account->addApiToken(new NostoApiToken('rates', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783'));

        $service = new NostoServiceCurrencyExchangeRate($account);
        $collection = new NostoCurrencyExchangeRateCollection();
        $collection->setValidUntil(new NostoDate(time() + (7 * 24 * 60 * 60)));
        $collection[] = new NostoCurrencyExchangeRate(new NostoCurrencyCode('EUR'), '0.706700000000');

        $this->specify('product recrawl with invalid URL', function() use ($service, $collection) {
            $this->setExpectedException('NostoHttpException');
            $service->update($collection);
        });
    }
}
