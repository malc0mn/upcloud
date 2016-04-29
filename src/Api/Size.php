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

use UpCloud\Entity\Size as SizeEntity;

/**
 * @author Shirleyson Kaisser <skaisser@gmail.com>
 */
class Size extends AbstractApi
{
    /**
     * @return SizeEntity[]
     */
    public function getAll()
    {
        $sizes = $this->adapter->get(sprintf('%s/sizes?per_page=%d', $this->endpoint, 200));

        $sizes = json_decode($sizes);

        $this->extractMeta($sizes);

        return array_map(function ($size) {
            return new SizeEntity($size);
        }, $sizes->sizes);
    }
}
