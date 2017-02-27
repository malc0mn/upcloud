<?php

namespace UpCloud\Entity;

final class Server extends AbstractEntity
{
    /**
     * @var string
     */
    public $bootOrder;

    /**
     * @var int
     */
    public $coreNumber;

    /**
     * @var string
     */
    public $firewall;

    /**
     * @var int
     */
    public $host;

    /**
     * @var string
     */
    public $hostname;

    /**
     * @var IpAddress[]
     */
    public $ipAddresses;

    /**
     * @var int
     */
    public $licence;

    /**
     * @var int
     */
    public $memoryAmount;

    /**
     * @var string
     */
    public $nicModel;

    /**
     * @var Plan
     */
    public $plan;

    /**
     * @var string
     */
    public $state;

    /**
     * @var Storage[]
     */
    public $storageDevices;

    /**
     * @var Tag[]
     */
    public $tags;

    /**
     * @var TimeZone
     */
    public $timezone;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $uuid;

    /**
     * @var string
     */
    public $videoModel;

    /**
     * @var string
     */
    public $vnc;

    /**
     * @var string
     */
    public $vncHost;

    /**
     * @var string
     */
    public $vncPassword;

    /**
     * @var string
     */
    public $vncPort;

    /**
     * @var Zone
     */
    public $zone;

    /**
     * @param array $parameters
     */
    public function build(array $parameters)
    {
        foreach ($parameters as $property => $value) {
            switch ($property) {
                case 'plan':
                    $this->plan = new Plan();
                    $this->plan->name = $value;

                    // Prevent from double processing.
                    unset($parameters[$property]);

                    break;

                case 'tags':
                    $this->tags = array_map(function ($name) {
                        $tag = new Tag();
                        $tag->name = $name;
                        return $tag;
                    }, $value->tag);

                    // Prevent from double processing.
                    unset($parameters[$property]);

                    break;

                case 'ip_addresses':
                    $this->ipAddresses = array_map(function ($ipAddress) {
                        return new IpAddress($ipAddress);
                    }, $value->ip_address);

                    // Prevent from double processing.
                    unset($parameters[$property]);

                    break;

                case 'storage_devices':
                    $this->storageDevices = array_map(function ($storage) {
                        return new StorageDevice($storage);
                    }, $value->storage_device);

                    // Prevent from double processing.
                    unset($parameters[$property]);

                    break;

                case 'timezone':
                    $this->timezone = new TimeZone();
                    $this->timezone->name = $value;

                    // Prevent from double processing.
                    unset($parameters[$property]);

                    break;

                case 'zone':
                    $this->zone = new Zone();
                    $this->zone->id = $value;

                    // Prevent from double processing.
                    unset($parameters[$property]);

                    break;
            }
        }

        parent::build($parameters);
    }
}
