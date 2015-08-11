<?php

require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaDataIframe.php');

class AccountTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

	/**
	 * Tests the "isConnectedToNosto" method for the NostoAccount class.
	 */
	public function testAccountIsConnected()
	{
		$account = new NostoAccount('platform-test');

		$this->specify('account is not connected', function() use ($account) {
			$this->assertFalse($account->isConnectedToNosto());
		});

		$token = new NostoApiToken('sso', '123');
		$account->addApiToken($token);

		$token = new NostoApiToken('products', '123');
		$account->addApiToken($token);

		$this->specify('account is NOT connected', function() use ($account) {
			$this->assertFalse($account->isConnectedToNosto());
		});

        $token = new NostoApiToken('rates', '123');
        $account->addApiToken($token);

        $token = new NostoApiToken('settings', '123');
        $account->addApiToken($token);

        $this->specify('account IS connected', function() use ($account) {
            $this->assertTrue($account->isConnectedToNosto());
        });
	}

	/**
	 * Tests the "getApiToken" method for the NostoAccount class.
	 */
	public function testAccountApiToken()
	{
		$account = new NostoAccount('platform-test');

		$this->specify('account does not have sso token', function() use ($account) {
			$this->assertNull($account->getApiToken('sso'));
		});

		$token = new NostoApiToken('sso', '123');
		$account->addApiToken($token);

		$this->specify('account has sso token', function() use ($account) {
			$this->assertEquals('123', $account->getApiToken('sso')->getValue());
		});
	}

	/**
	 * Tests the "ssoLogin" method for the NostoAccount class without the sso token.
	 */
	public function testAccountSingleSignOnWithoutToken()
	{
		$account = new NostoAccount('platform-test');
		$meta = new NostoAccountMetaDataIframe();

        $this->setExpectedException('NostoException');

        $account->ssoLogin($meta);
	}

    /**
     * Tests the "ssoLogin" method for the NostoAccount class with the sso token.
     */
    public function testAccountSingleSignOnWithToken()
    {
        $account = new NostoAccount('platform-test');
        $token = new NostoApiToken('sso', '123');
        $account->addApiToken($token);
        $meta = new NostoAccountMetaDataIframe();

        $this->specify('account has sso token', function() use ($account, $meta) {
            $this->assertEquals('https://nosto.com/auth/sso/sso%2Bplatform-00000000@nostosolutions.com/xAd1RXcmTMuLINVYaIZJJg', $account->ssoLogin($meta));
        });
    }
}
