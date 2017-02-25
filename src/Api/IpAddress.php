<?php

/**
 * https://www.upcloud.com/api/10-ip-addresses/
 */

namespace UpCloud\Api;

use UpCloud\Entity\IpAddress as IpAddressEntity;
use UpCloud\Exception\HttpException;

class IpAddress extends AbstractApi
{
    /**
     * https://www.upcloud.com/api/10-ip-addresses/#list-ip-addresses
     *
     * @return IpAddressEntity[]
     */
    public function getAll()
    {
        $result = $this->adapter->get(sprintf('%s/ip_address', $this->endpoint));

        $result = json_decode($result);

        return array_map(function ($ip) {
            return new IpAddressEntity($ip);
        }, $result->ip_addresses->ip_address);
    }

    /**
     * https://www.upcloud.com/api/10-ip-addresses/#get-ip-address-details
     *
     * @param string $ip
     *
     * @throws HttpException
     *
     * @return IpAddressEntity
     */
    public function getByUniqueIp($ip)
    {
        $result = $this->adapter->get(sprintf('%s/ip_address/%s', $this->endpoint, $ip));

        $result = json_decode($result);

        return new IpAddressEntity($result->ip_address);
    }

    /**
     * https://www.upcloud.com/api/10-ip-addresses/#assign-ip-address
     *
     * @param string $server UUID of the server to attach the IP to.
     * @param string $family IPv4|IPv6 The address family of new IP address
     *
     * @return IpAddressEntity
     */
    public function assign($server, $family) {
        $data['ip_address'] = [
            'server' => $server,
            'family' => $family,
        ];

        $result = $this->adapter->post(sprintf('%s/ip_address', $this->endpoint), $data);

        $result = json_decode($result);

        return new IpAddressEntity($result->ip_address);
    }

    /**
     * https://www.upcloud.com/api/10-ip-addresses/#modify-ip-address
     *
     * @param string $ip
     * @param string $ptrRecord A fully qualified domain name.
     *
     * @return IpAddressEntity
     */
    public function modify($ip, $ptrRecord) {
        $data['ip_address'] = [
            'ptr_record' => $ptrRecord
        ];

        $result = $this->adapter->put(sprintf('%s/ip_address/%s', $this->endpoint, $ip), $data);

        $result = json_decode($result);

        return new IpAddressEntity($result->ip_address);
    }

    /**
     * https://www.upcloud.com/api/10-ip-addresses/#release-ip-address
     *
     * @param string $ip The IP address to remove
     *
     * @throws HttpException
     */
    public function release($ip)
    {
        $this->adapter->delete(sprintf('%s/ip_address/%s', $this->endpoint, $ip));
    }
}
