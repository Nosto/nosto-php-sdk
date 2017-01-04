<?php

interface NostoSerializableInterface
{
    /**
     * @return array the array representation of the object for serialization
     */
    public function getArray();
}
