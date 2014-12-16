<?php

require_once(dirname(__FILE__) . '/../../src/config.inc.php');

class NostoAccountMetaDataOwner implements NostoAccountMetaDataOwnerInterface
{
	public function getFirstName()
	{
		return 'James';
	}
	public function getLastName()
	{
		return 'Kirk';
	}
	public function getEmail()
	{
		return 'james.kirk@example.com';
	}
}

class NostoAccountMetaDataBilling implements NostoAccountMetaDataBillingDetailsInterface
{
	public function getCountry()
	{
		return 'us';
	}
}

class NostoAccountMetaData implements NostoAccountMetaDataInterface
{
	protected $owner;
	protected $billing;
	public function __construct()
	{
		$this->owner = new NostoAccountMetaDataOwner();
		$this->billing = new NostoAccountMetaDataBilling();
	}
	public function getTitle()
	{
		return 'My Shop';
	}
	public function getName()
	{
		return 'magento-00000000';
	}
	public function getPlatform()
	{
		return 'magento';
	}
	public function getFrontPageUrl()
	{
		return 'http://localhost';
	}
	public function getCurrencyCode()
	{
		return 'USD';
	}
	public function getLanguageCode()
	{
		return 'en';
	}
	public function getOwnerLanguageCode()
	{
		return 'en';
	}
	public function getOwner()
	{
		return $this->owner;
	}
	public function getBillingDetails()
	{
		return $this->billing;
	}
}

class AccountCreateTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testCreatingNewAccount()
    {
		$meta = new NostoAccountMetaData();
		$account = NostoAccount::create($meta);

		$this->specify('account was created', function() {
			$this->assertTrue(get_class($account) === 'NostoAccount');
		});
    }
}
