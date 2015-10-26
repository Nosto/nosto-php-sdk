<?php

class NostoProductVariationMock implements NostoProductVariationInterface
{
    public function getVariationId()
    {
        return 'EUR';
    }

    public function getCurrency()
    {
        return new NostoCurrencyCode('EUR');
    }

    public function getPrice()
    {
        return new NostoPrice(88.76);
    }

    public function getListPrice()
    {
        return new NostoPrice(98.52);
    }

    public function getAvailability()
    {
        return new NostoProductAvailability('InStock');
    }

    public function getUrl()
    {
        return null;
    }

    public function getName()
    {
        return null;
    }

    public function getImageUrl()
    {
        return null;
    }

    public function getThumbUrl()
    {
        return null;
    }

    public function getTags()
    {
        return array();
    }

    public function getCategories()
    {
        return array();
    }

    public function getDescription()
    {
        return null;
    }

    public function getBrand()
    {
        return null;
    }

    public function getDatePublished()
    {
        return null;
    }
}
