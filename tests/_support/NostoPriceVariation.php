<?php

class NostoPriceVariation implements NostoProductPriceVariationInterface
{
    public function getId()
    {
        return 'EUR';
    }
    public function getCurrencyCode()
    {
        return 'EUR';
    }
    public function getPrice()
    {
        return 88.76;
    }
    public function getListPrice()
    {
        return 98.52;
    }
    public function getAvailability()
    {
        return 'InStock';
    }
}
