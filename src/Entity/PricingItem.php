<?php

namespace UpCloud\Entity;

final class PricingItem extends AbstractEntity
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $amount;

    /**
     * @var float
     *
     * price of amount per hour in cents
     */
    public $price;

    function getPricePerMonth(){
        return $this->price * 24 * 30;
    }
}
