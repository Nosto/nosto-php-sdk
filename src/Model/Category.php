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

namespace Nosto\Model;

use Nosto\Mixins\HtmlEncoderTrait;
use Nosto\Types\CategoryInterface;
use Nosto\AbstractObject;
use Nosto\Types\HtmlEncodableInterface;
use Nosto\Types\MarkupableInterface;

/**
 * Category object for tagging
 */
class Category extends AbstractObject implements
    CategoryInterface,
    MarkupableInterface,
    HtmlEncodableInterface
{
    use HtmlEncoderTrait;

    /**
     * @var string categoryString
     */
    private $categoryString;

    /**
     * @var string id
     */
    private $id;

    /**
     * @var string parentId
     */
    private $parentId;

    /**
     * @var string name
     */
    private $name;

    /**
     * @var string url
     */
    private $url;

    /**
     * @var string imageUrl
     */
    private $imageUrl;

    /**
     * @var string thumbnailImageUrl
     */
    private $thumbnailImageUrl;

    /**
     * @var bool
     */
    private $visibleInMenu;

    /**
     * @var string level
     */
    private $level;

    /**
     * @return string
     */
    public function getCategoryString()
    {
        return $this->categoryString;
    }

    /**
     * @param string $categoryString
     */
    public function setCategoryString($categoryString)
    {
        $this->categoryString = $categoryString;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param int|string $parentId
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getThumbnailImageUrl()
    {
        return $this->thumbnailImageUrl;
    }

    /**
     * @param string $thumbnailImageUrl
     */
    public function setThumbnailImageUrl($thumbnailImageUrl)
    {
        $this->thumbnailImageUrl = $thumbnailImageUrl;
    }

    /**
     * @return bool
     */
    public function getVisibleInMenu()
    {
        return $this->visibleInMenu;
    }

    /**
     * @param $visibleInMenu
     */
    public function setVisibleInMenu($visibleInMenu)
    {
        $this->visibleInMenu = $visibleInMenu ? true : false;
    }

    /**
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param int|string $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return string
     */
    public function getMarkupKey()
    {
        return 'nosto_category';
    }
}
