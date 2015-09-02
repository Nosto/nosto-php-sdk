<?php

require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaDataBilling.php');
require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaDataOwner.php');
require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaData.php');

class AccountUpdateTest extends \Codeception\TestCase\Test
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
	 * Tests that new accounts can be created successfully.
	 */
	public function testUpdatingAccount()
    {
        $account = new NostoAccount('platform-test');
        $account->addApiToken(new NostoApiToken('settings', '123'));
		$meta = new NostoAccountMetaData();
        $service = new NostoServiceAccount();
		$result = $service->update($account, $meta);

		$this->specify('account was updated', function() use ($result) {
			$this->assertTrue($result);
		});
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testHttpFailure()
    {
        NostoApiRequest::$baseUrl = 'http://localhost:1234'; // not a real url

        $account = new NostoAccount('platform-test');
        $account->addApiToken(new NostoApiToken('settings', '123'));

        $meta = new NostoAccountMetaData();
        $service = new NostoServiceAccount();

        $this->specify('account update with invalid URL', function() use ($service, $account, $meta) {
            $this->setExpectedException('NostoHttpException');
            $service->update($account, $meta);
        });
    }
}
