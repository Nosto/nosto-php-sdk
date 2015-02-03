<?php


class AccountDeleteTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Test the account deletion without the required SSO token.
     */
    public function testDeletingAccountWithoutToken()
    {
        $account = new NostoAccount();

        $this->specify('account is NOT deleted', function() use ($account) {
            $this->setExpectedException('NostoException');
            $account->delete();
        });
    }

    /**
     * Test the account deletion with the required SSO token.
     */
    public function testDeletingAccountWithToken()
    {
        $account = new NostoAccount();

        $token = new NostoApiToken();
        $token->name = 'sso';
        $token->value = '123';
        $account->tokens[] = $token;

        $this->specify('account is deleted', function() use ($account) {
            $account->delete();
        });
    }
}