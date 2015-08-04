<?php

class NostoAccountMetaData implements NostoAccountMetaInterface
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
		return '00000000';
	}
	public function getPlatform()
	{
		return 'platform';
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
	public function getSignUpApiToken()
	{
		return 'abc123';
	}
    public function getPartnerCode()
    {
        return null;
    }
    public function getCurrencies()
    {
        return array(
            new NostoCurrency('USD', '$', 'left', ',', '.', 3, 2)
        );
    }
}
