<?php

require_once(dirname(__FILE__) . '/../_support/NostoOrderBuyer.php');
require_once(dirname(__FILE__) . '/../_support/NostoOrderPurchasedItem.php');
require_once(dirname(__FILE__) . '/../_support/NostoOrderStatus.php');
require_once(dirname(__FILE__) . '/../_support/NostoOrder.php');

class ServiceOrderTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

	/**
	 * @var NostoOrder
	 */
	protected $order;

	/**
	 * @var NostoAccount
	 */
	protected $account;

	/**
	 * @inheritdoc
	 */
	protected function _before()
	{
        // Configure API, Web Hooks, and OAuth client to use Mock server when testing.
        NostoApiRequest::$baseUrl = 'http://localhost:3000';
        NostoOAuthClient::$baseUrl = 'http://localhost:3000';
        NostoHttpRequest::$baseUrl = 'http://localhost:3000';

		$this->order = new NostoOrder();
		$this->account = new NostoAccount('platform-00000000');
	}

	/**
	 * Tests the matched order confirmation API call.
	 */
	public function testMatchedOrderConfirmation()
    {
        $service = new NostoServiceOrder($this->account);
        $result = $service->confirm($this->order, 'test123');

		$this->specify('successful matched order confirmation', function() use ($result) {
			$this->assertTrue($result);
		});
    }

	/**
	 * Tests the un-matched order confirmation API call.
	 */
	public function testUnMatchedOrderConfirmation()
	{
        $service = new NostoServiceOrder($this->account);
        $result = $service->confirm($this->order);

		$this->specify('successful un-matched order confirmation', function() use ($result) {
			$this->assertTrue($result);
		});
	}

    /**
     * Tests that the service fails correctly.
     */
    public function testHttpFailure()
    {
        NostoApiRequest::$baseUrl = 'http://localhost:1234'; // not a real url

        $this->specify('order confirmation with invalid URL', function() {
            $this->setExpectedException('NostoHttpException');
            $service = new NostoServiceOrder($this->account);
            $service->confirm($this->order, 'test123');
        });
    }
}
