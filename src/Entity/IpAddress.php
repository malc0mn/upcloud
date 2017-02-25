<?php

namespace UpCloud\Entity;

final class IpAddress extends AbstractEntity
{
    /**
     * @var string private|public
     */
    public $access;

    /**
     * @var string
     */
    public $address;

    /**
     * @var string IPv4|IPv6
     */
    public $family;

    /**
     * @var string yes|no
     */
    public $partOfPlan;

    /**
     * @var string
     */
    public $ptrRecord;

    /**
     * @var string
     */
    public $server;
}
