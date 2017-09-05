<?php

namespace UpCloud\Entity;

final class Pricing extends AbstractEntity
{
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
    public $io_request_backup;

    /**
     * @var PricingItem
     */
    public $io_request_maxiops;

    /**
     * @var PricingItem
     */
    public $ipv4_address;

    /**
     * @var PricingItem
     */
    public $ipv6_address;

    /**
     * @var PricingItem
     */
    public $public_ipv4_bandwidth_in;

    /**
     * @var PricingItem
     */
    public $public_ipv4_bandwidth_out;

    /**
     * @var PricingItem
     */
    public $public_ipv6_bandwidth_in;

    /**
     * @var PricingItem
     */
    public $public_ipv6_bandwidth_out;

    /**
     * @var PricingItem
     */
    public $server_core;

    /**
     * @var PricingItem
     */
    public $server_memory;

    /**
     * @var array PricingItem
     */
    public $server_plans;

    /**
     * @var PricingItem
     */
    public $storage_backup;

    /**
     * @var PricingItem
     */
    public $storage_maxiops;

    /**
     * @var PricingItem
     */
    public $storage_template;

    /**
     * @param array $parameters
     */
    public function build(array $parameters) {

        $server_plan_prefix = 'server_plan_';
        $server_plan_len = strlen($server_plan_prefix);

        foreach ($parameters as $property => $value) {
            if($property === 'name'){
                continue;
            }

            $pricingItem = new PricingItem($value);
            $pricingItem->name = $property;
            $pricingItem->m = $pricingItem->getPricePerMonth();

            if( substr($property, 0, $server_plan_len) === $server_plan_prefix){
                $this->server_plans[str_replace ( $server_plan_prefix , '', $property)] = $pricingItem;
            } else {
                $this->$property = $pricingItem;
            }

            // Prevent from double processing.
            unset($parameters[$property]);
        }

        parent::build($parameters);
    }
}
