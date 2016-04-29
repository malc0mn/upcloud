<?php

/*
 * This file is part of the UpCloud library.
 *
 * (c) Shirleyson Kaisser <skaisser@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UpCloud\Api;

use UpCloud\Entity\RateLimit as RateLimitEntity;

/**
 * @author Shirleyson Kaisser <skaisser@gmail.com>
 */
class RateLimit extends AbstractApi
{
    /**
     * @return RateLimitEntity|null
     */
    public function getRateLimit()
    {
        if ($results = $this->adapter->getLatestResponseHeaders()) {
            return new RateLimitEntity($results);
        }
    }
}
