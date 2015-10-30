<?php

class NostoOrderMock implements NostoOrderInterface
{
	public function getOrderNumber()
	{
		return 1;
	}
    public function getExternalRef()
    {
        return '#0001';
    }
	public function getCreatedDate()
	{
		return new NostoDate(strtotime('2014-12-12'));
	}
	public function getPaymentProvider()
	{
        $paymentProvider = new NostoOrderPaymentProvider();
        $paymentProvider->setName('test-gateway');
        $paymentProvider->setVersion('1.0.0');
        return $paymentProvider;
	}
	public function getBuyer()
	{
        $buyer = new NostoOrderBuyer();
        $buyer->setFirstName('James');
        $buyer->setLastName('Kirk');
        $buyer->setEmail('james.kirk@example.com');
        return $buyer;
	}
	public function getItems()
	{
        $item = new NostoOrderItem();
        $item->setItemId(1);
        $item->setQuantity(1);
        $item->setName('Test Product');
        $item->setUnitPrice(new NostoPrice(99.99));
        $item->setCurrency(new NostoCurrencyCode('USD'));
		return array($item);
	}
	public function getStatus()
	{
        $status = new NostoOrderStatus();
        $status->setCode('completed');
        $status->setLabel('Completed');
        return $status;
	}
    public function getHistoryStatuses()
    {
        return array();
    }
}
