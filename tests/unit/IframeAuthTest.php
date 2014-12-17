<?php

require_once(dirname(__FILE__) . '/../_support/NostoAccountMetaDataIframe.php');

class IframeAuthTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

	/**
	 * Tests that we can build an authenticated url for the config iframe.
	 */
	public function testIframeUrlAuthentication()
    {
		/** @var NostoAccount $account */
		$account = new NostoAccount();
		$account->name = 'platform-00000000';
		$meta = new NostoAccountMetaDataIframe();

		$url = $account->getIframeUrl($meta);

		$this->specify('failed to create authenticated iframe url', function() use ($url) {
			$this->assertFalse($url);
		});

		$token = new NostoApiToken();
		$token->name = 'sso';
		$token->value = '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783';
		$account->tokens[] = $token;

		$url = $account->getIframeUrl($meta);

		$this->specify('authenticated iframe url was created', function() use ($url) {
			$this->assertEquals('https://nosto.com/auth/sso/sso%2Bplatform-00000000@nostosolutions.com/xAd1RXcmTMuLINVYaIZJJg?r=%2Fhub%2Fprestashop%2Fplatform-00000000%3Flang%3Den%26ps_version%3D1.0.0%26nt_version%3D1.0.0%26product_pu%3Dhttp%253A%252F%252Fmy.shop.com%252Fproducts%252Fproduct123%253Fnostodebug%253Dtrue%26category_pu%3Dhttp%253A%252F%252Fmy.shop.com%252Fproducts%252Fcategory123%253Fnostodebug%253Dtrue%26search_pu%3Dhttp%253A%252F%252Fmy.shop.com%252Fsearch%253Fquery%253Dred%253Fnostodebug%253Dtrue%26cart_pu%3Dhttp%253A%252F%252Fmy.shop.com%252Fcart%253Fnostodebug%253Dtrue%26front_pu%3Dhttp%253A%252F%252Fmy.shop.com%253Fnostodebug%253Dtrue%26shop_lang%3Den%26unique_id%3D123', $url);
		});
    }
}
