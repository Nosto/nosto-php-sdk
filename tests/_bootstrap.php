<?php
// This is global bootstrap for autoloading

// Pre-load all sdk classes.
require_once(dirname(__FILE__) . '/../src/config.inc.php');

// Configure API and OAuth client to use Mock server when testing.
NostoApiRequest::$baseUrl = 'http://localhost:3000';
NostoOAuthClient::$baseUrl = 'http://localhost:3000';
