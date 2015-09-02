<?php

require_once(dirname(__FILE__) . '/../_support/NostoProduct.php');

class ServiceRecrawlTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var NostoAccount
     */
    private $account;

    /**
     * @var NostoServiceRecrawl
     */
    private $service;

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        // Configure API, Web Hooks, and OAuth client to use Mock server when testing.
        NostoApiRequest::$baseUrl = 'http://localhost:3000';
        NostoOAuthClient::$baseUrl = 'http://localhost:3000';
        NostoHttpRequest::$baseUrl = 'http://localhost:3000';

        $this->account = new NostoAccount('platform-00000000');
        foreach (NostoApiToken::getApiTokenNames() as $tokenName) {
            $this->account->addApiToken(new NostoApiToken($tokenName, '123'));
        }
        $this->service = new NostoServiceRecrawl($this->account);
    }

	/**
	 * Tests that product re-crawl API requests can be made.
	 */
	public function testProductReCrawl()
    {
        $this->service->addProduct(new NostoProduct());
        $result = $this->service->send();

		$this->specify('successful product re-crawl', function() use ($result) {
			$this->assertTrue($result);
		});
    }

    /**
     * Tests that product re-crawl API requests cannot be made without any products.
     */
    public function testProductReCrawlWithoutProducts()
    {
        $this->setExpectedException('NostoException');
        $this->service->send();
    }

    /**
     * Tests that product re-crawl API requests cannot be made without an API token.
     */
    public function testProductReCrawlWithoutToken()
    {
        $this->setExpectedException('NostoException');
        $service = new NostoServiceRecrawl(new NostoAccount('platform-00000000'));
        $service->addProduct(new NostoProduct());
        $service->send();
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testProductReCrawlHttpFailure()
    {
        NostoApiRequest::$baseUrl = 'http://localhost:1234'; // not a real url

        $this->setExpectedException('NostoHttpException');
        $this->service->addProduct(new NostoProduct());
        $this->service->send();
    }
}
