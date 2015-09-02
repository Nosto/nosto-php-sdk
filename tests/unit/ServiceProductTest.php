<?php

require_once(dirname(__FILE__) . '/../_support/NostoProduct.php');

class ServiceProductTest extends \Codeception\TestCase\Test
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
	 * Tests that product upsert API requests cannot be made without an API token.
	 */
	public function testSendingProductUpsertWithoutApiToken()
	{
		$account = new NostoAccount('platform-00000000');
		$product = new NostoProduct();

		$this->setExpectedException('NostoException');
		$service = new NostoServiceProduct($account);
		$service->addProduct($product);
		$service->upsert();
	}

	/**
	 * Tests that product upsert API requests cannot be made without products.
	 */
	public function testSendingProductUpsertWithoutProduct()
	{
		$account = new NostoAccount('platform-00000000');
		$token = new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
		$account->addApiToken($token);

		$this->setExpectedException('NostoException');
		$service = new NostoServiceProduct($account);
		$service->upsert();
	}

	/**
	 * Tests that product upsert API requests can be made.
	 */
	public function testSendingProductUpsert()
	{
		$account = new NostoAccount('platform-00000000');
		$product = new NostoProduct();
		$token = new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
		$account->addApiToken($token);

		$service = new NostoServiceProduct($account);
		$service->addProduct($product);
		$result = $service->upsert();

		$this->specify('successful product upsert', function() use ($result) {
			$this->assertTrue($result);
		});
	}

    /**
     * Tests that product update API requests cannot be made without an API token.
     */
    public function testSendingProductUpdateWithoutApiToken()
    {
        $account = new NostoAccount('platform-00000000');
        $product = new NostoProduct();

        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct($account);
        $service->addProduct($product);
        $service->update();
    }

    /**
     * Tests that product update API requests cannot be made without products.
     */
    public function testSendingProductUpdateWithoutProduct()
    {
        $account = new NostoAccount('platform-00000000');
        $token = new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
        $account->addApiToken($token);

        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct($account);
        $service->update();
    }

    /**
     * Tests that product update API requests can be made.
     */
    public function testSendingProductUpdate()
    {
        $account = new NostoAccount('platform-00000000');
        $product = new NostoProduct();
		$token = new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
		$account->addApiToken($token);

        $service = new NostoServiceProduct($account);
        $service->addProduct($product);
        $result = $service->update();

        $this->specify('successful product update', function() use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that product create API requests cannot be made without an API token.
     */
    public function testSendingProductCreateWithoutApiToken()
    {
        $account = new NostoAccount('platform-00000000');
        $product = new NostoProduct();

        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct($account);
        $service->addProduct($product);
        $service->create();
    }


    /**
     * Tests that product create API requests cannot be made without products.
     */
    public function testSendingProductCreateWithoutProduct()
    {
        $account = new NostoAccount('platform-00000000');
		$token = new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
		$account->addApiToken($token);

        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct($account);
        $service->create();
    }

    /**
     * Tests that product create API requests can be made.
     */
    public function testSendingProductCreate()
    {
        $account = new NostoAccount('platform-00000000');
        $product = new NostoProduct();
		$token = new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
		$account->addApiToken($token);

        $service = new NostoServiceProduct($account);
        $service->addProduct($product);
        $result = $service->create();

        $this->specify('successful product create', function() use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that product delete API requests cannot be made without an API token.
     */
    public function testSendingProductDeleteWithoutApiToken()
    {
        $account = new NostoAccount('platform-00000000');
        $product = new NostoProduct();

        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct($account);
        $service->addProduct($product);
        $service->delete();
    }

    /**
     * Tests that product delete API requests cannot be made without products.
     */
    public function testSendingProductDeleteWithoutProduct()
    {
        $account = new NostoAccount('platform-00000000');
		$token = new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
		$account->addApiToken($token);

        $this->setExpectedException('NostoException');
        $service = new NostoServiceProduct($account);
        $service->delete();
    }

    /**
     * Tests that product delete API requests can be made.
     */
    public function testSendingProductDelete()
    {
        $account = new NostoAccount('platform-00000000');
        $product = new NostoProduct();
		$token = new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783');
		$account->addApiToken($token);

        $service = new NostoServiceProduct($account);
        $service->addProduct($product);
        $result = $service->delete();

        $this->specify('successful product delete', function() use ($result) {
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
        $account->addApiToken(new NostoApiToken('products', '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783'));

        $service = new NostoServiceProduct($account);
        $service->addProduct(new NostoProduct());

        $this->specify('product upsert with invalid URL', function() use ($service) {
            $this->setExpectedException('NostoHttpException');
            $service->upsert();
        });

        $this->specify('product create with invalid URL', function() use ($service) {
            $this->setExpectedException('NostoHttpException');
            $service->create();
        });

        $this->specify('product update with invalid URL', function() use ($service) {
            $this->setExpectedException('NostoHttpException');
            $service->update();
        });

        $this->specify('product delete with invalid URL', function() use ($service) {
            $this->setExpectedException('NostoHttpException');
            $service->delete();
        });
    }
}
