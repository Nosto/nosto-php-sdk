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

namespace Nosto\Operation\Search;

use Exception;
use Nosto\Model\Search\Analytics\CategoryImpression;
use Nosto\NostoException;
use Nosto\Operation\AbstractAuthenticatedOperation;
use Nosto\Request\Api\ApiRequest;
use Nosto\Request\Http\Exception\AbstractHttpException;
use Nosto\Result\Api\GeneralPurposeResultHandler;
use Nosto\Types\Signup\AccountInterface;

/**
 * Operation class for upserting and deleting products through the Nosto API.
 * A product upsert will create the product if it doesn't exist or update it if
 * it does, while a product delete also results in an upsert but flags the
 * product's availability as 'Discontinued'
 */
class AnalyticsCategoryImpressions extends AbstractAuthenticatedOperation
{
    /**
     * @var string customer id (2cid)
     */
    private $customer;

    /**
     * Constructor.
     *
     * @param AccountInterface $account the account object.
     * @param string $customer
     * @param string $activeDomain
     */
    public function __construct(AccountInterface $account, $customer, $activeDomain = '')
    {
        parent::__construct($account, $activeDomain);
        $this->customer = $customer;
    }

    /**
     * Sends a POST request to create or update all the products currently in the collection.
     *
     * @return bool if the request was successful.
     * @throws AbstractHttpException
     * @throws NostoException on failure.
     * @throws Exception
     */
    public function sendAnalytics(CategoryImpression $impression)
    {
        $request = $this->initRequest(
            null,
            $this->account->getName(),
            $this->activeDomain,
            false
        );
        $response = $request->post($impression);
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
        return ApiRequest::PATH_ANALYTICS_CATEGORY_IMPRESSIONS . "?merchant=" . $this->account->getName() . "&customer=" . $this->customer;
    }
}