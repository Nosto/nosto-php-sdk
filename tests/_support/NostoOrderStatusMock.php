<?php

class NostoOrderStatusMock implements NostoOrderStatusInterface
{
	public function getCode()
	{
		return 'completed';
	}

	public function getLabel()
	{
		return 'Completed';
	}

    public function getCreatedAt()
    {
        return null;
    }
}
