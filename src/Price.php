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
 * @copyright Copyright (c) 2013-2015 Nosto Solutions Ltd (http://www.nosto.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Value Object representing a price value.
 */
final class NostoPrice
{
    /**
     * @var string the price.
     */
    private $price;

    /**
     * Constructor.
     * Sets up the Value Object with given data.
     *
     * @param string|int|float $price the price.
     *
     * @throws NostoInvalidArgumentException
     */
    public function __construct($price)
    {
        if (!is_numeric($price)) {
            throw new NostoInvalidArgumentException(sprintf(
                '%s._price (%s) must be a numeric value.',
                __CLASS__,
                $price
            ));
        }

        $this->price = (string)$price;
    }

    /**
     * Returns the price value.
     *
     * @return string the price.
     */
    public function getPrice()
    {
        return $this->price;
    }
}
