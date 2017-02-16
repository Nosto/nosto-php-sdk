<?php
/**
 * Copyright (c) 2017, Nosto Solutions Ltd
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
 * @copyright 2017 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

class NostoProduct implements NostoProductInterface, NostoValidatableInterface
{
	public function getUrl()
	{
		return 'http://my.shop.com/products/test_product.html';
	}
	public function getProductId()
	{
		return 1;
	}
	public function getName()
	{
		return 'Test Product';
	}
	public function getImageUrl()
	{
		return 'http://my.shop.com/images/test_product.jpg';
	}
	public function getPrice()
	{
		return 99.99;
	}
	public function getListPrice()
	{
		return 110.99;
	}

	public function getFullDescription()
	{
		return 'This is a full description';
	}

	public function getCurrencyCode()
	{
		return 'USD';
	}
	public function getAvailability()
	{
		return 'InStock';
	}
	public function getTags()
	{
		return array('tag1', 'tag2');
	}
	public function getCategories()
	{
		return array('/a/b', '/a/b/c');
	}
    public function getShortDescription()
    {
        return 'Lorem ipsum dolor sit amet';
    }
	public function getDescription()
	{
		return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris imperdiet ligula eu facilisis dignissim.';
	}
	public function getBrand()
	{
		return 'Super Brand';
	}
	public function getValidationRules()
	{
		return array(
			array(array('url', 'productId', 'name', 'imageUrl', 'price', 'listPrice', 'currencyCode', 'availability'), 'required')
		);
	}
	public function __get($name)
	{
		$getter = 'get'.$name;
		if (method_exists($this, $getter)) {
			return $this->{$getter}();
		}
		throw new Exception(sprintf('Property `%s.%s` is not defined.', get_class($this), $name));
	}

	public function getVariationId()
	{
		return false;
	}

    public function getSupplierCost()
    {
        return null;
    }

    public function getInventoryLevel()
    {
        return null;
    }

    public function getReviewCount()
    {
        return null;
    }

    public function getRatingValue()
    {
        return null;
    }

    public function getAlternateImageUrls()
    {
        return null;
    }

    public function getCondition()
    {
        return null;
    }

    public function getGender()
    {
        return null;
    }

    public function getAgeGroup()
    {
        return null;
    }

    public function getGtin()
    {
        return null;
    }

    public function getGoogleCategory()
    {
        return null;
    }

    public function getUnitPricingMeasure()
    {
        return null;
    }

    public function getUnitPricingBaseMeasure()
    {
        return null;
    }

    public function getUnitPricingUnit()
    {
        return null;
    }


}
