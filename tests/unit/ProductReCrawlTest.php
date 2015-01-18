<?php

require_once(dirname(__FILE__) . '/../_support/NostoProduct.php');

class ProductReCrawlTest extends \Codeception\TestCase\Test
{
	use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

	/**
	 * Tests that product re-crawl API requests can be made.
	 */
	public function testSendingProductReCrawl()
    {
		$account = new NostoAccount();
		$account->name = 'platform-00000000';
		$product = new NostoProduct();

		$result = NostoProductReCrawl::send($product, $account);

		$this->specify('failed product re-crawl', function() use ($result) {
			$this->assertFalse($result);
		});

		$token = new NostoApiToken();
		$token->name = 'products';
		$token->value = '01098d0fc84ded7c4226820d5d1207c69243cbb3637dc4bc2a216dafcf09d783';
		$account->tokens[] = $token;

		$result = NostoProductReCrawl::send($product, $account);

		$this->specify('successful product re-crawl', function() use ($result) {
			$this->assertTrue($result);
		});
    }
}
