<?php

require_once(dirname(__FILE__) . '/../_support/NostoProductMock.php');

/** @noinspection PhpUndefinedClassInspection */
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
    protected function _before() // @codingStandardsIgnoreLine
    {
        $this->account = new NostoAccount('platform-00000000');
        foreach (NostoApiToken::getApiTokenNames() as $tokenName) {
            $this->account->addApiToken(new NostoApiToken($tokenName, '123'));
        }
        $this->service = new NostoServiceRecrawl($this->account);
    }

    /**
     * @inheritdoc
     */
    protected function _after() // @codingStandardsIgnoreLine
    {
        \AspectMock\Test::clean();
    }

    /**
     * Tests that product re-crawl API requests can be made.
     */
    public function testProductReCrawl()
    {
        $this->service->addProduct(new NostoProductMock());
        $result = $this->service->send();

        $this->specify('successful product re-crawl', function () use ($result) {
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
        $service->addProduct(new NostoProductMock());
        $service->send();
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testProductReCrawlHttpFailure()
    {
        \AspectMock\Test::double('NostoHttpResponse', ['getCode' => 404]);

        $this->setExpectedException('NostoHttpException');
        $this->service->addProduct(new NostoProductMock());
        $this->service->send();
    }
}
