<?php

require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaDataBilling.php');
require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaDataOwner.php');
require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaData.php');
require_once(dirname(__FILE__) . '/../_support/NostoOAuthClientMetaData.php');

class ServiceAccountTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var NostoServiceAccount
     */
    private $service;

    /**
     * @var NostoAccountMetaData
     */
    private $meta;

    /**
     * @var NostoAccount
     */
    private $account;

    /**
     * @inheritdoc
     */
    protected function _before()
    {
        // Configure API, Web Hooks, and OAuth client to use Mock server when testing.
        NostoApiRequest::$baseUrl = 'http://localhost:3000';
        NostoOAuthClient::$baseUrl = 'http://localhost:3000';
        NostoHttpRequest::$baseUrl = 'http://localhost:3000';

        $this->service = new NostoServiceAccount();
        $this->meta = new NostoAccountMetaData();
        $this->account = new NostoAccount('platform-00000000');
        foreach (NostoApiToken::getApiTokenNames() as $tokenName) {
            $this->account->addApiToken(new NostoApiToken($tokenName, '123'));
        }
    }

    /**
     * Tests that an account can be created.
     */
    public function testAccountCreate()
    {
        $account = $this->service->create($this->meta);
        $expectedAccountName = $this->meta->getPlatform().'-'.$this->meta->getName();

        $this->specify('account was created', function() use ($account, $expectedAccountName) {
            $this->assertInstanceOf('NostoAccount', $account);
            $this->assertEquals($expectedAccountName, $account->getName());
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
     * Tests that the account creation fails correctly on http errors.
     */
    public function testAccountCreateHttpFailure()
    {
        NostoApiRequest::$baseUrl = 'http://localhost:1234'; // not a real url

        $this->setExpectedException('NostoHttpException');
        $this->service->create($this->meta);
    }

    /**
     * Tests that an account can be updated.
     */
    public function testAccountUpdate()
    {
        $result = $this->service->update($this->account, $this->meta);

        $this->specify('account was updated', function() use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that an account cannot be updated without the API token.
     */
    public function testAccountUpdateWithoutToken()
    {
        $account = new NostoAccount('platform-00000000');

        $this->setExpectedException('NostoException');
        $this->service->update($account, $this->meta);
    }

    /**
     * Tests that the account update fails correctly on http errors.
     */
    public function testAccountUpdateHttpFailure()
    {
        NostoApiRequest::$baseUrl = 'http://localhost:1234'; // not a real url

        $this->setExpectedException('NostoHttpException');
        $this->service->update($this->account, $this->meta);
    }


    /**
     * Tests that an account can be synced.
     */
    public function testAccountSync()
    {
        $oauthMeta = new NostoOAuthClientMetaData();
        $client = new NostoOAuthClient($oauthMeta);

        $this->specify('oauth authorize url can be created', function() use ($client) {
            $this->assertEquals('http://localhost:3000?client_id=client-id&redirect_uri=http%3A%2F%2Fmy.shop.com%2Fnosto%2Foauth&response_type=code&scope=sso products&lang=en', $client->getAuthorizationUrl());
        });

        $account = $this->service->sync($oauthMeta, 'test123');

        $this->specify('account was synced', function() use ($account) {
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
     * Tests that the account sync fails correctly on http errors.
     */
    public function testAccountSyncHttpFailure()
    {
        NostoOAuthClient::$baseUrl = 'http://localhost:1234'; // not a real url

        $this->setExpectedException('NostoHttpException');
        $this->service->sync(new NostoOAuthClientMetaData(), 'test123');
    }

    /**
     * Tests that an account can be re-synced.
     */
    public function testAccountReSync()
    {
        $oldAccount = $this->account;

        $oauthMeta = new NostoOAuthClientMetaData();
        $oauthMeta->setAccount($oldAccount);
        $client = new NostoOAuthClient($oauthMeta);

        $this->specify('oauth authorize url can be created', function() use ($client) {
            $this->assertEquals('http://localhost:3000?client_id=client-id&redirect_uri=http%3A%2F%2Fmy.shop.com%2Fnosto%2Foauth&response_type=code&scope=sso+products&lang=en&merchant=platform-00000000', $client->getAuthorizationUrl());
        });

        $service = new NostoServiceAccount();
        $newAccount = $service->sync($oauthMeta, 'test123');

        $this->specify('account was re-synced', function() use ($newAccount) {
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

        $this->specify('account is connected to nosto', function() use ($newAccount, $oauthMeta) {
            $this->assertTrue($newAccount->isConnectedToNosto());
        });
    }

    /**
     * Tests that the account re-sync fails correctly on http errors.
     */
    public function testAccountReSyncHttpFailure()
    {
        NostoOAuthClient::$baseUrl = 'http://localhost:1234'; // not a real url

        $oauthMeta = new NostoOAuthClientMetaData();
        $oauthMeta->setAccount($this->account);

        $this->setExpectedException('NostoHttpException');
        $this->service->sync($oauthMeta, 'test123');
    }

    /**
     * Tests that an account can be deleted.
     */
    public function testAccountDelete()
    {
        $result = $this->service->delete($this->account);

        $this->specify('account is deleted', function() use ($result) {
            $this->assertTrue($result);
        });
    }

    /**
     * Tests that an account cannot be deleted without the API token.
     */
    public function testAccountDeleteWithoutToken()
    {
        $this->setExpectedException('NostoException');
        $this->service->delete(new NostoAccount('platform-00000000'));
    }

    /**
     * Tests that the account delete fails correctly on http errors.
     */
    public function testAccountDeleteHttpFailure()
    {
        NostoHttpRequest::$baseUrl = 'http://localhost:1234'; // not a real url

        $this->setExpectedException('NostoHttpException');
        $this->service->delete($this->account);
    }
}
