<?php

/*
 * This file is part of the UpCloud library.
 *
 * (c) Shirleyson Kaisser <skaisser@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UpCloud\Entity;

/**
 * @author Shirleyson Kaisser <skaisser@gmail.com>
 */
final class Image extends AbstractEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $distribution;

    /**
     * @var string
     */
    public $slug;

    /**
     * @var int
     */
    public $minDiskSize;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var bool
     */
    public $public;

    /**
     * @var string[]
     */
    public $regions = [];

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = static::convertDateTime($createdAt);
    }
}
