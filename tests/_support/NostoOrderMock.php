<?php

class NostoOrderMock implements NostoOrderInterface
{
	public function getOrderNumber()
	{
		return 1;
	}
    public function getExternalOrderRef()
    {
        return '#0001';
    }
	public function getCreatedDate()
	{
		return new NostoDate(strtotime('2014-12-12'));
	}
	public function getPaymentProvider()
	{
		return 'test-gateway [1.0.0]';
	}
	public function getBuyerInfo()
	{
		return new NostoOrderBuyerMock();
	}
	public function getPurchasedItems()
	{
		return array(new NostoOrderPurchasedItemMock());
	}
	public function getOrderStatus()
	{
		return new NostoOrderStatusMock();
	}
    public function getOrderStatuses()
    {
        return array();
    }
}
