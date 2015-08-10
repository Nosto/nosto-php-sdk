<?php

class NostoPriceVariation implements NostoProductPriceVariationInterface
{
    public function getId()
    {
        return 'EUR';
    }

    public function getCurrencyCode()
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
}
