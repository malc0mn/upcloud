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

    /**
     * Return the monthprice based on 30days a month.
     *
     * Be carefull, some items this is not the price you pay per month.
     *
     *
     * @return float|int
     */
    function getPricePerMonth() {
        return $this->price * 24 * 30;
    }

    function getPriceForAmount($amount) {
        return ($amount / $this->amount) * $this->price;
    }
}
