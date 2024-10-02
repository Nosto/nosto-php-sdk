<?php
/**
 * Copyright (c) 2020, Nosto Solutions Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its contributors
 * may be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Nosto Solutions Ltd <contact@nosto.com>
 * @copyright 2020 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Operation;

use Exception;
use Nosto\NostoException;
use Nosto\Model\Product\ProductCollection;
use Nosto\Request\Api\ApiRequest;
use Nosto\Request\Api\Token;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Result\Api\GeneralPurposeResultHandler;
use Nosto\Types\Product\ProductInterface;
use Nosto\Types\Signup\AccountInterface;

/**
 * Operation class for upserting product id's with urls and requesting a recrawl through the Nosto API.
 */
class RecrawlProduct extends AbstractAuthenticatedOperation
{
    /**
     * @var ProductCollection collection object of products to perform the operation on.
     */
    private $collection;

    /**
     * Constructor.
     *
     * @param AccountInterface $account the account object.
     * @param string $activeDomain
     */
    public function __construct(AccountInterface $account, $activeDomain = '')
    {
        parent::__construct($account, $activeDomain);
        $this->collection = new ProductCollection();
    }

    /**
     * Adds a product tho the collection on which the operation is the performed.
     *
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product)
    {
        $this->collection->append($product);
    }

    /**
     * Wrapper to call clear collection
     */
    public function clearCollection()
    {
        $this->collection->clear();
    }

    /**
     * Sends a POST request to recrawl all the products currently in the collection
     *
     * @return bool if the request was successful.
     * @throws AbstractHttpException
     * @throws NostoException on failure.
     * @throws Exception
     */
    public function requestRecrawl()
    {
        $request = $this->initRequest(
            $this->account->getApiToken(Token::API_PRODUCTS),
            $this->account->getName(),
            $this->activeDomain
        );
        if ($this->collection->count() === 0) {
            return true;
        }
        $products = [
            "products" => []
        ];

        foreach ($this->collection as $product) {
            $products["products"][] = [
                "product_id" => $product->getProductId(),
                "url" => $product->getUrl()
            ];
        }
        $response = $request->postRaw(json_encode($products, JSON_THROW_ON_ERROR));
        return $request->getResultHandler()->parse($response);
    }

    /**
     * @inheritdoc
     */
    protected function getResultHandler()
    {
        return new GeneralPurposeResultHandler();
    }

    /**
     * @inheritdoc
     */
    protected function getRequestType()
    {
        return new ApiRequest();
    }

    /**
     * @inheritdoc
     */
    protected function getContentType()
    {
        return self::CONTENT_TYPE_APPLICATION_JSON;
    }

    /**
     * @inheritdoc
     */
    protected function getPath()
    {
        return ApiRequest::PATH_PRODUCT_RE_CRAWL;
    }
}
