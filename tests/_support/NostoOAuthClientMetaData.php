<?php

class NostoOAuthClientMetaData implements NostoOauthClientMetaInterface
{
	public function getClientId()
	{
		return 'client-id';
	}
	public function getClientSecret()
	{
		return 'client-secret';
	}
	public function getRedirectUrl()
	{
		return 'http://my.shop.com/nosto/oauth';
	}
	public function getScopes()
	{
		return array('sso', 'products');
	}
	public function getLanguage()
	{
		return new NostoLanguageCode('en');
	}
    public function getAccount()
    {
        return null;
    }
}
