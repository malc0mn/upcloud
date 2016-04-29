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
final class Size extends AbstractEntity
{
    /**
     * @var string
     */
    public $slug;

    /**
     * @var bool
     */
    public $available;

    /**
     * @var int
     */
    public $memory;

    /**
     * @var int
     */
    public $vcpus;

    /**
     * @var int
     */
    public $disk;

    /**
     * @var int
     */
    public $transfer;

    /**
     * @var string
     */
    public $priceMonthly;

    /**
     * @var string
     */
    public $priceHourly;

    /**
     * @var string[]
     */
    public $regions = [];
}
