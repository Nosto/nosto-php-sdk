<?php
/**
 * Copyright (c) 2019, Nosto Solutions Ltd
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
 * @copyright 2019 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Operation\Recommendation;

use Nosto\Operation\AbstractGraphQLOperation;
use Nosto\Result\Graphql\Recommendation\RecommendationResultHandler;
use Nosto\Types\Signup\AccountInterface;

/**
 * Abstract base operation class to be used in recommendation related operations
 */
abstract class AbstractRecommendation extends AbstractGraphQLOperation
{
    const LIMIT = 10;

    /** @var bool $previewMode */
    protected $previewMode;

    /** @var string $customerId */
    protected $customerId;

    /** @var string $customerBy */
    protected $customerBy;

    /** @var int $limit */
    protected $limit;

    /**
     * AbstractRecommendation constructor.
     * @param AccountInterface $account
     * @param $customerId
     * @param string $activeDomain
     * @param string $customerBy
     * @param bool $previewMode
     * @param int $limit
     */
    public function __construct(
        AccountInterface $account,
        $customerId,
        $activeDomain = '',
        $customerBy = self::IDENTIFIER_BY_CID,
        $previewMode = false,
        $limit = self::LIMIT
    ) {
        $this->limit = $limit;
        $this->customerBy = $customerBy;
        $this->customerId = $customerId;
        $this->previewMode = $previewMode;
        parent::__construct($account, $activeDomain);
    }


    /**
     * Returns if recos should use preview mode. You can set asString to
     * true and when the method returns true or false as a string. This is
     * needed for constructing the query.
     *
     * @param bool $asString
     * @return bool|string
     */
    public function isPreviewMode($asString = false)
    {
        if ($asString) {
            return $this->previewMode ? 'true' : 'false';
        }
        return $this->previewMode;
    }

    /**
     * @inheritdoc
     */
    protected function getResultHandler()
    {
        return new RecommendationResultHandler();
    }
}
