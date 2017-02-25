<?php

/**
 * https://www.upcloud.com/api/6-timezones/
 */

namespace UpCloud\Api;

use UpCloud\Entity\TimeZone as TimeZoneEntity;

class TimeZone extends AbstractApi
{
    /**
     * @return TimeZoneEntity[]
     */
    public function getAll()
    {
        $result = $this->adapter->get(sprintf('%s/timezone', $this->endpoint, 200));

        $result = json_decode($result);

        return array_map(function ($name) {
            $timeZone = new TimeZoneEntity();
            $timeZone->name = $name;
            return $timeZone;
        }, $result->timezones->timezone);
    }
}
