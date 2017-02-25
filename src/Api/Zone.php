<?php

/**
 * https://www.upcloud.com/api/5-zones/
 */

namespace UpCloud\Api;

use UpCloud\Entity\Zone as ZoneEntity;

class Zone extends AbstractApi
{
    /**
     * @return ZoneEntity[]
     */
    public function getAll()
    {
        $result = $this->adapter->get(sprintf('%s/zone', $this->endpoint, 200));

        $result = json_decode($result);

        return array_map(function ($zone) {
            return new ZoneEntity($zone);
        }, $result->zones->zone);
    }
}
