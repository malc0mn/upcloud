<?php

namespace UpCloud\Entity;

final class Pricing extends AbstractEntity {
    /**
     * @var string
     */
    public $name;

    /**
     * @var PricingItem
     */
    public $firewall;

    /**
     * @var PricingItem
     */
    public $ioRequestBackup;

    /**
     * @var PricingItem
     */
    public $ioRequestMaxiops;

    /**
     * @var PricingItem
     */
    public $ipv4Address;

    /**
     * @var PricingItem
     */
    public $ipv6Address;

    /**
     * @var PricingItem
     */
    public $publicIpv4BandwidthIn;

    /**
     * @var PricingItem
     */
    public $publicIpv4BandwidthOut;

    /**
     * @var PricingItem
     */
    public $publicIpv6BandwidthIn;

    /**
     * @var PricingItem
     */
    public $publicIpv6BandwidthOut;

    /**
     * @var PricingItem
     */
    public $serverCore;

    /**
     * @var PricingItem
     */
    public $serverMemory;

    /**
     * @var array PricingItem
     */
    public $serverPlans;

    /**
     * @var PricingItem
     */
    public $storageBackup;

    /**
     * @var PricingItem
     */
    public $storageMaxiops;

    /**
     * @var PricingItem
     */
    public $storageTemplate;

    /**
     * @param array $parameters
     */
    public function build(array $parameters) {

        $serverPlanPrefix = 'server_plan_';
        $serverPlanLen = strlen($serverPlanPrefix);

        foreach ($parameters as $property => $value) {
            if ($property === 'name') {
                continue;
            }
            // Prevent from double processing.
            unset($parameters[$property]);

            $pricingItem = new PricingItem($value);
            $pricingItem->name = $property;

            if (substr($property, 0, $serverPlanLen) === $serverPlanPrefix) {
                $this->serverPlans[str_replace($serverPlanPrefix, '', $property)] = $pricingItem;
                continue;
            }
            $ccProperty = static::convertToCamelCase($property);
            $this->$ccProperty = $pricingItem;
        }

        parent::build($parameters);
    }

    //public function
}
