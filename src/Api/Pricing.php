<?php

/**
 * https://www.upcloud.com/api/4-pricing/
 */

namespace UpCloud\Api;

use UpCloud\Entity\Pricing as PricingEntity;

class Pricing extends AbstractApi
{
    /**
     * https://www.upcloud.com/api/4-pricing/#list-prices
     *
     * @return PricingEntity[]
     */
    public function listPrices()
    {
        $result = $this->adapter->get(sprintf('%s/price', $this->endpoint));

        $result = json_decode($result);

        return $this->arrayMapKeys(array_map(function ($price) {
            return new PricingEntity($price);
        }, $result->prices->zone), 'name');
    }
}
