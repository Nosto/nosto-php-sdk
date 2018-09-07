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
class CategoryBrowsingHistory extends AbstractHistory
{
    private $category;

    /**
     * @inheritdoc
     */
    public function getQuery()
    {
        $query
            = <<<QUERY
        {
            "query": "mutation(
                    \$customerId: String!,
                    \$limit: Int!,
                    \$preview: Boolean!
                    \$category: String!
            ) { 
                updateSession(by: BY_CID, id: \$customerId, params: {
                    event: { 
                        type: VIEWED_CATEGORY
                        target: \$category
                    }     
                }) {
                    id,
                    recos (preview: \$preview, image: VERSION_8_400_400) {
                        category_ids: history(
                            params: {
                                minProducts: 1,
                                maxProducts: \$limit,
                                include: {
                                    categories: [\$category]
                                }
                            }
                        ) {
                            primary {
                                productId
                            }     
                        }
                    }
                }
            }",
            "variables": {
                "customerId": "%s",
                "category": "%s", 
                "limit": "%d",
                "preview": %s
            }
        }
QUERY;
        $formatted = sprintf(
            $query,
            $this->getCustomerId(),
            $this->category,
            $this->getLimit(),
            $this->isPreviewMode(true)
        );

        return $formatted;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }
}
