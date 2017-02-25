<?php

/**
 * https://www.upcloud.com/api/7-plans/
 */

namespace UpCloud\Api;

use UpCloud\Entity\Plan as PlanEntity;

class Plan extends AbstractApi
{
    /**
     * https://www.upcloud.com/api/7-plans/#list-available-plans
     *
     * @return PlanEntity[]
     */
    public function getAll()
    {
        $result = $this->adapter->get(sprintf('%s/plan', $this->endpoint, 200));

        $result = json_decode($result);

        return array_map(function ($plan) {
            return new PlanEntity($plan);
        }, $result->plans->plan);
    }
}
