<?php

require_once(dirname(__FILE__) . '/../_support/NostoOAuthClientMetaData.php');

class AccountSyncTest extends \Codeception\TestCase\Test
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
	 * Tests that existing accounts can be synced from Nosto.
	 * Accounts are synced using OAuth2 Authorization Code method.
	 * We are only testing that we can start and act on the steps in the OAuth request cycle.
	 */
	public function testSyncingExistingAccount()
    {
		$meta = new NostoOAuthClientMetaData();
		$client = new NostoOAuthClient($meta);

		$this->specify('oauth authorize url can be created', function() use ($client) {
			$this->assertEquals('http://localhost:3000?client_id=client-id&redirect_uri=http%3A%2F%2Fmy.shop.com%2Fnosto%2Foauth&response_type=code&scope=sso products&lang=en', $client->getAuthorizationUrl());
		});

        $service = new NostoServiceAccount();
        $account = $service->sync($meta, 'test123');

		$this->specify('account was created', function() use ($account) {
			$this->assertInstanceOf('NostoAccount', $account);
			$this->assertEquals('platform-00000000', $account->getName());
		});

        foreach (NostoApiToken::getApiTokenNames() as $tokenName) {
            $this->specify("account has api token {$tokenName}", function() use ($account, $tokenName) {
                $token = $account->getApiToken($tokenName);
                $this->assertInstanceOf('NostoApiToken', $token);
                $this->assertEquals($tokenName, $token->getName());
                $this->assertNotEmpty($token->getValue());
            });
        }

		$this->specify('account is connected to nosto', function() use ($account) {
			$this->assertTrue($account->isConnectedToNosto());
		});
    }

    /**
     * Tests that accounts can be granted more API tokens by re-syncing it from Nosto.
     * Accounts are synced using OAuth2 Authorization Code method.
     * We are only testing that we can start and act on the steps in the OAuth request cycle.
     */
    public function testReSyncingExistingAccount()
    {
        $oldAccount = new NostoAccount('platform-00000000');

        $meta = new NostoOAuthClientMetaData();
        $meta->setAccount($oldAccount);
        $client = new NostoOAuthClient($meta);

        $this->specify('oauth authorize url can be created', function() use ($client) {
            $this->assertEquals('http://localhost:3000?client_id=client-id&redirect_uri=http%3A%2F%2Fmy.shop.com%2Fnosto%2Foauth&response_type=code&scope=sso+products&lang=en&merchant=platform-00000000', $client->getAuthorizationUrl());
        });

        $service = new NostoServiceAccount();
        $newAccount = $service->sync($meta, 'test123');

        $this->specify('account was synced', function() use ($newAccount) {
            $this->assertInstanceOf('NostoAccount', $newAccount);
            $this->assertEquals('platform-00000000', $newAccount->getName());
        });

        $this->specify('new account equals old account', function() use ($newAccount, $oldAccount) {
            $this->assertTrue($newAccount->equals($oldAccount));
        });

        foreach (NostoApiToken::getApiTokenNames() as $tokenName) {
            $this->specify("account has api token {$tokenName}", function() use ($newAccount, $tokenName) {
                $token = $newAccount->getApiToken($tokenName);
                $this->assertInstanceOf('NostoApiToken', $token);
                $this->assertEquals($tokenName, $token->getName());
                $this->assertNotEmpty($token->getValue());
            });
        }

        $this->specify('account is connected to nosto', function() use ($newAccount, $meta) {
            $this->assertTrue($newAccount->isConnectedToNosto());
        });
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testHttpFailure()
    {
        NostoOAuthClient::$baseUrl = 'http://localhost:1234'; // not a real url

        $meta = new NostoOAuthClientMetaData();

        $service = new NostoServiceAccount();

        $this->specify('account sync with invalid URL', function() use ($service, $meta) {
            $this->setExpectedException('NostoHttpException');
            $service->sync($meta, 'test123');
        });
    }
}
