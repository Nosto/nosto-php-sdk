<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Nosto
 * @package   Nosto_Tagging
 * @author    Nosto Solutions Ltd <magento@nosto.com>
 * @copyright Copyright (c) 2013-2017 Nosto Solutions Ltd (http://www.nosto.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Nosto\Operation\Recommendation;

use Nosto\Request\Api\ApiRequest;
use Nosto\Request\Grapql\GraphqlRequest;
use Nosto\Types\Signup\AccountInterface;
use Nosto\Request\Api\Token;

/**
 * Operation class for getting product ids in a category
 */
abstract class AbstractTopList extends AbstractRecommendationOperation
{

    const DEFAULT_LIMIT = 10;
    const DEFAULT_HOURS = 168;
    const DEFAULT_SORT = 'VIEWS';
    const SORT_VIEWS = 'VIEWS';
    const SORT_BUYS = 'BUYS';

    private $sort;
    private $hours;

    /**
     * Category constructor
     *
     * @param AccountInterface $account
     * @param string $customerId
     * @param int $limit
     * @param int $hours
     * @param string $sort
     */
    public function __construct(
        AccountInterface $account,
        $customerId,
        $limit = self::DEFAULT_LIMIT,
        $hours = self::DEFAULT_HOURS,
        $sort = self::DEFAULT_SORT
    ) {
        parent::__construct($account);
        $this->setCustomerId($customerId);
        $this->setLimit($limit);
        $this->setLimit($limit);
        $this->setHours($hours);
        $this->setSort($sort);
    }

    /**
     * @return mixed
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param mixed $sort
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    /**
     * @return mixed
     */
    public function getHours()
    {
        return $this->hours;
    }

    /**
     * @param mixed $hours
     */
    public function setHours($hours)
    {
        $this->hours = $hours;
    }
}
