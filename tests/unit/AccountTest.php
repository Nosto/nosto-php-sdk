<?php

require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaDataSingleSignOn.php');

class AccountTest extends \Codeception\TestCase\Test
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
	 * Tests the account service SSO without the sso token.
	 */
	public function testAccountSingleSignOnWithoutToken()
	{
		$account = new NostoAccount('platform-test');
		$meta = new NostoAccountMetaDataSingleSignOn();

        $this->setExpectedException('NostoException');

        $service = new NostoServiceAccount();
        $service->sso($account, $meta);
	}

    /**
     * Tests the account service SSO with the sso token.
     */
    public function testAccountSingleSignOnWithToken()
    {
        $account = new NostoAccount('platform-test');
        $token = new NostoApiToken('sso', '123');
        $account->addApiToken($token);
        $meta = new NostoAccountMetaDataSingleSignOn();

        $this->specify('account has sso token', function() use ($account, $meta) {
            $service = new NostoServiceAccount();
            $url = $service->sso($account, $meta);
            $this->assertEquals('https://nosto.com/auth/sso/sso%2Bplatform-00000000@nostosolutions.com/xAd1RXcmTMuLINVYaIZJJg', $url);
        });
    }

    /**
     * Test that you cannot create a nosto account object with an invalid name.
     */
    public function testInvalidAccountName()
    {
        $this->setExpectedException('NostoInvalidArgumentException');

        new NostoAccount(null);
    }

    /**
     * Test the account object equals method.
     */
    public function testAccountEquality()
    {
        $oldAccount = new NostoAccount('platform-test');
        $newAccount = new NostoAccount('platform-test');

        $this->specify('two accounts are equal', function() use ($oldAccount, $newAccount) {
                $this->assertTrue($newAccount->equals($oldAccount));
                $this->assertTrue($oldAccount->equals($newAccount));
            });
    }

    /**
     * Tests that account tokens can be fetched.
     */
    public function testAccountTokenGetter()
    {
        $account = new NostoAccount('platform-test');
        $token = new NostoApiToken('sso', '123');
        $account->addApiToken($token);
        $tokens = $account->getTokens();

        $this->specify('account tokens were retreived', function() use ($tokens) {
                $this->assertNotEmpty($tokens);
            });
    }
}
