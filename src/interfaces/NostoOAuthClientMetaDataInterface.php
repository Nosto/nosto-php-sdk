<?php

interface NostoOAuthClientMetaDataInterface
{
	public function getClientId();
	public function getClientSecret();
	public function getRedirectUrl();
	public function getScopes();
	public function getLanguageIsoCode();
}