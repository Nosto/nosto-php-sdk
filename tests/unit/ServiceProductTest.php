<?php

require_once(dirname(__FILE__) . '/../_support/NostoProductMock.php');

/** @noinspection PhpUndefinedClassInspection */
class ServiceProductTest extends \Codeception\TestCase\Test
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
     * @var NostoServiceProduct
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
        $this->service = new NostoServiceProduct($this->account);
    }

    /**
     * @inheritdoc
     */
    protected function _after() // @codingStandardsIgnoreLine
    {
        \AspectMock\Test::clean();
    }

    /**
     * Tests that product upsert API requests cannot be made without an API token.
     */
    public function testProductUpsertWithoutApiToken()
    {
        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct(new NostoAccount('platform-00000000'));
        $service->addProduct(new NostoProductMock());
        $service->upsert();
    }

    /**
     * Tests that product upsert API requests cannot be made without products.
     */
    public function testProductUpsertWithoutProduct()
    {
        $this->setExpectedException('NostoException');
        $this->service->upsert();
    }

    /**
     * Tests that product upsert API requests can be made.
     */
    public function testProductUpsert()
    {
        $this->service->addProduct(new NostoProductMock());
        $result = $this->service->upsert();

        $this->specify('successful product upsert', function () use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that product update API requests cannot be made without an API token.
     */
    public function testProductUpdateWithoutApiToken()
    {
        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct(new NostoAccount('platform-00000000'));
        $service->addProduct(new NostoProductMock());
        $service->update();
    }

    /**
     * Tests that product update API requests cannot be made without products.
     */
    public function testProductUpdateWithoutProduct()
    {
        $this->setExpectedException('NostoException');
        $this->service->update();
    }

    /**
     * Tests that product update API requests can be made.
     */
    public function testProductUpdate()
    {
        $this->service->addProduct(new NostoProductMock());
        $result = $this->service->update();

        $this->specify('successful product update', function () use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that product create API requests cannot be made without an API token.
     */
    public function testProductCreateWithoutApiToken()
    {
        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct(new NostoAccount('platform-00000000'));
        $service->addProduct(new NostoProductMock());
        $service->create();
    }

    /**
     * Tests that product create API requests cannot be made without products.
     */
    public function testProductCreateWithoutProduct()
    {
        $this->setExpectedException('NostoException');
        $this->service->create();
    }

    /**
     * Tests that product create API requests can be made.
     */
    public function testProductCreate()
    {
        $this->service->addProduct(new NostoProductMock());
        $result = $this->service->create();

        $this->specify('successful product create', function () use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that product delete API requests cannot be made without an API token.
     */
    public function testProductDeleteWithoutApiToken()
    {
        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct(new NostoAccount('platform-00000000'));
        $service->addProduct(new NostoProductMock());
        $service->delete();
    }

    /**
     * Tests that product delete API requests cannot be made without products.
     */
    public function testProductDeleteWithoutProduct()
    {
        $this->setExpectedException('NostoException');
        $this->service->delete();
    }

    /**
     * Tests that product delete API requests can be made.
     */
    public function testProductDelete()
    {
        $this->service->addProduct(new NostoProductMock());
        $result = $this->service->delete();

        $this->specify('successful product delete', function () use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testProductUpsertHttpFailure()
    {
        \AspectMock\Test::double('NostoHttpResponse', ['getCode' => 404]);

        $this->setExpectedException('NostoHttpException');
        $this->service->addProduct(new NostoProductMock());
        $this->service->upsert();
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testProductCreateHttpFailure()
    {
        \AspectMock\Test::double('NostoHttpResponse', ['getCode' => 404]);

        $this->setExpectedException('NostoHttpException');
        $this->service->addProduct(new NostoProductMock());
        $this->service->create();
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testProductUpdateHttpFailure()
    {
        \AspectMock\Test::double('NostoHttpResponse', ['getCode' => 404]);

        $this->setExpectedException('NostoHttpException');
        $this->service->addProduct(new NostoProductMock());
        $this->service->update();
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testProductDeleteHttpFailure()
    {
        \AspectMock\Test::double('NostoHttpResponse', ['getCode' => 404]);

        $this->setExpectedException('NostoHttpException');
        $this->service->addProduct(new NostoProductMock());
        $this->service->delete();
    }
}
