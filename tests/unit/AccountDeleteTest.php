<?php


class AccountDeleteTest extends \Codeception\TestCase\Test
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
     * Test the account deletion without the required SSO token.
     */
    public function testDeletingAccountWithoutToken()
    {
        $account = new NostoAccount('platform-test');

        $this->specify('account is NOT deleted', function() use ($account) {
            $this->setExpectedException('NostoException');
            $service = new NostoServiceAccount();
            $service->delete($account);
        });
    }

    /**
     * Test the account deletion with the required SSO token.
     */
    public function testDeletingAccountWithToken()
    {
        $account = new NostoAccount('platform-test');
        $token = new NostoApiToken('sso', '123');
		$account->addApiToken($token);

        $this->specify('account is deleted', function() use ($account) {
            $service = new NostoServiceAccount();
            $service->delete($account);
        });
    }

    /**
     * Tests that the service fails correctly.
     */
    public function testHttpFailure()
    {
        NostoHttpRequest::$baseUrl = 'http://localhost:1234'; // not a real url

        $account = new NostoAccount('platform-test');
        $account->addApiToken(new NostoApiToken('sso', '123'));

        $service = new NostoServiceAccount();

        $this->specify('account delete with invalid URL', function() use ($service, $account) {
            $this->setExpectedException('NostoHttpException');
            $service->delete($account);
        });
    }
}