<?php

/**
 * https://www.upcloud.com/api/11-firewall/
 */

namespace UpCloud\Api;

use UpCloud\Entity\FirewallRule as FirewallEntity;
use UpCloud\Exception\HttpException;

class Firewall extends AbstractApi
{
    /**
     * https://www.upcloud.com/api/11-firewall/#list-firewall-rules
     *
     * @param string $uuid The server UUID to get the firewall rules for.
     *
     * @return FirewallEntity[]
     */
    public function getAll($uuid)
    {
        $result = $this->adapter->get(sprintf('%s/server/%s/firewall_rule', $this->endpoint, $uuid));

        $result = json_decode($result);

        return array_map(function ($rule) {
            return new FirewallEntity($rule);
        }, $result->firewall_rules->firewall_rule);
    }

    /**
     * https://www.upcloud.com/api/11-firewall/#get-firewall-rule-details
     *
     * @param string $uuid The server UUID to get the firewall rules for.
     * @param int $index The index of the firewall rule in the server's firewall
     *                   rule list.
     *
     * @throws HttpException
     *
     * @return FirewallEntity
     */
    public function getByIndex($uuid, $index)
    {
        $result = $this->adapter->get(sprintf('%s/server/%s/firewall_rule/%d', $this->endpoint, $uuid, $index));

        $result = json_decode($result);

        return new FirewallEntity($result->ip_address);
    }

    /**
     * https://www.upcloud.com/api/11-firewall/#create-firewall-rule
     *
     * @param string $uuid UUID of the server to create the firewall rule for.
     * @param string $family IPv4|IPv6 The address family of new IP address
     *
     * @return FirewallEntity
     */
    public function create($uuid, FirewallEntity $rule) {
        $data['firewall_rule'] = $rule->toApiPostData();

        $result = $this->adapter->post(sprintf('%s/server/%s/firewall_rule', $this->endpoint, $uuid), $data);

        $result = json_decode($result);

        return new FirewallEntity($result->ip_address);
    }

    /**
     * https://www.upcloud.com/api/10-ip-addresses/#release-ip-address
     *
     * @param string $uuid The IP address to remove
     * @param int $index 1-1000 Position of the firewall rule to remove.
     *
     * @throws HttpException
     */
    public function release($uuid, $index)
    {
        $this->adapter->delete(sprintf('%s/server/%s/firewall_rule/%d', $this->endpoint, $uuid, $index));
    }
}
