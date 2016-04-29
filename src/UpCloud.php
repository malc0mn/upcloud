<?php

/*
 * This file is part of the UpCloud library.
 *
 * (c) Shirleyson Kaisser <skaisser@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UpCloud;

use UpCloud\Adapter\AdapterInterface;
use UpCloud\Api\Account;
use UpCloud\Api\Action;
use UpCloud\Api\Domain;
use UpCloud\Api\DomainRecord;
use UpCloud\Api\Droplet;
use UpCloud\Api\FloatingIp;
use UpCloud\Api\Image;
use UpCloud\Api\Key;
use UpCloud\Api\RateLimit;
use UpCloud\Api\Region;
use UpCloud\Api\Size;

/**
 * @author Shirleyson Kaisser <skaisser@gmail.com>
 */
class UpCloud
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return Account
     */
    public function account()
    {
        return new Account($this->adapter);
    }

    /**
     * @return Action
     */
    public function action()
    {
        return new Action($this->adapter);
    }

    /**
     * @return Domain
     */
    public function domain()
    {
        return new Domain($this->adapter);
    }

    /**
     * @return DomainRecord
     */
    public function domainRecord()
    {
        return new DomainRecord($this->adapter);
    }

    /**
     * @return Droplet
     */
    public function droplet()
    {
        return new Droplet($this->adapter);
    }

    /**
     * @return FloatingIp
     */
    public function floatingIp()
    {
        return new FloatingIp($this->adapter);
    }

    /**
     * @return Image
     */
    public function image()
    {
        return new Image($this->adapter);
    }

    /**
     * @return Key
     */
    public function key()
    {
        return new Key($this->adapter);
    }

    /**
     * @return RateLimit
     */
    public function rateLimit()
    {
        return new RateLimit($this->adapter);
    }

    /**
     * @return Region
     */
    public function region()
    {
        return new Region($this->adapter);
    }

    /**
     * @return Size
     */
    public function size()
    {
        return new Size($this->adapter);
    }
}
