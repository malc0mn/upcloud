<?php

namespace UpCloud;

use UpCloud\Adapter\AdapterInterface;
use UpCloud\Api\Account;
use UpCloud\Api\Firewall;
use UpCloud\Api\IpAddress;
use UpCloud\Api\Plan;
use UpCloud\Api\Pricing;
use UpCloud\Api\Server;
use UpCloud\Api\Storage;
use UpCloud\Api\Tag;
use UpCloud\Api\TimeZone;
use UpCloud\Api\Zone;

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
     * @return Pricing
     */
    public function pricing()
    {
        return new Pricing($this->adapter);
    }

    /**
     * @return Zone
     */
    public function zone()
    {
        return new Zone($this->adapter);
    }

    /**
     * @return TimeZone
     */
    public function timeZone()
    {
        return new TimeZone($this->adapter);
    }

    /**
     * @return Plan
     */
    public function plan()
    {
        return new Plan($this->adapter);
    }

    /**
     * @return Server
     */
    public function server()
    {
        return new Server($this->adapter);
    }

    /**
     * @return Storage
     */
    public function storage()
    {
        return new Storage($this->adapter);
    }

    /**
     * @return IpAddress
     */
    public function ipAddress()
    {
        return new IpAddress($this->adapter);
    }

    /**
     * @return Firewall
     */
    public function firewall()
    {
        return new Firewall($this->adapter);
    }

    /**
     * @return Tag
     */
    public function tag()
    {
        return new Tag($this->adapter);
    }
}
