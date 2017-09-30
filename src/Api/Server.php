<?php

/**
 * https://www.upcloud.com/api/8-servers/
 */

namespace UpCloud\Api;

use UpCloud\Entity\IpAddress;
use UpCloud\Entity\Server as ServerEntity;
use UpCloud\Entity\Size as SizeEntity;
use UpCloud\Entity\StorageDevice;
use UpCloud\Exception\HttpException;

class Server extends AbstractApi
{
    /**
     * https://www.upcloud.com/api/8-servers/#list-server-configurations
     *
     * @return SizeEntity[]
     */
    public function listServerConfigurations()
    {
        $result = $this->adapter->get(sprintf('%s/server_size', $this->endpoint));

        $result = json_decode($result);

        return array_map(function ($server) {
            return new SizeEntity($server);
        }, $result->server_sizes->server_size);
    }

    /**
     * https://www.upcloud.com/api/8-servers/#list-servers
     *
     * @param null|string $indexProperty
     *
     * @return ServerEntity[]
     */
    public function listServers($indexProperty = null)
    {
        $result = $this->adapter->get(sprintf('%s/server', $this->endpoint));

        $result = json_decode($result);

        $array = array_map(function ($server) {
            return new ServerEntity($server);
        }, $result->servers->server);

        if ($indexProperty !== null) {
            return $this->arrayMapKeys($array, $indexProperty);
        }
        return $array;
    }

    /**
     * https://www.upcloud.com/api/8-servers/#get-server-details
     *
     * @param string $uuid
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function getByUniqueId($uuid)
    {
        $result = $this->adapter->get(sprintf('%s/server/%s', $this->endpoint, $uuid));

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }

    /**
     * https://www.upcloud.com/api/8-servers/#create-server
     *
     * @param string $zone
     * @param string $title
     * @param string $hostname
     * @param string $plan
     * @param StorageDevice[] $storageDevices
     * @param IpAddress[] $ipAddresses
     * @param array $additionalOptions
     *
     * @return ServerEntity
     */
    public function create(
        $zone,
        $title,
        $hostname,
        array $storageDevices,
        $plan = null,
        array $ipAddresses = [],
        array $additionalOptions = []
    ) {
        // TODO: add some validation, see Attributes tables on
        // https://www.upcloud.com/api/8-servers/#create-server

        $data = [
            'zone' => $zone,
            'title' => $title,
            'hostname' => $hostname,
        ];

        if ($plan !== null) {
            $data['plan'] = $plan;
        }

        foreach ($storageDevices as $storageDevice) {
            $data['storage_devices']['storage_device'][] = $storageDevice->toApiPostData();
        }

        foreach ($ipAddresses as $ipAddress) {
            $data['ip_addresses']['ip_address'][] = $ipAddress->toApiPostData();
        }

        if (isset($additionalOptions['plan'])) {
            $data['plan'] = $additionalOptions['plan'];
        }

        if (isset($additionalOptions['username'])) {
            $data['login_user']['username'] = $additionalOptions['username'];
        }

        if (isset($additionalOptions['sshKeys']) && 0 < count($additionalOptions['sshKeys'])) {
            $data['login_user']['ssh_keys']['ssh_key'] = $additionalOptions['sshKeys'];
            $data['login_user']['create_password'] = 'no';
        }

        if (isset($additionalOptions['userData'])) {
            $data['user_data'] = $additionalOptions['userData'];
        }

        $result = $this->adapter->post(sprintf('%s/server', $this->endpoint), ['server' => $data]);

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }

    /**
     * https://www.upcloud.com/api/8-servers/#start-server
     *
     * @param string $uuid
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function start($uuid)
    {
        return $this->executeAction($uuid, 'start');
    }

    /**
     * https://www.upcloud.com/api/8-servers/#stop-server
     *
     * @param string $uuid
     * @param string $type soft|hard
     * @param int $timeout
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function stop(
        $uuid,
        $type = 'soft',
        $timeout = 60
    ) {
        $params['stop_server'] = [
            'stop_type' => $type,
        ];

        // Mandatory when type is 'soft'.
        if ($timeout) {
            $params['stop_server']['timeout'] = $timeout;
        }

        return $this->executeAction($uuid, 'stop', $params);
    }

    /**
     * https://www.upcloud.com/api/8-servers/#restart-server
     *
     * @param string $uuid
     * @param string $type soft|hard
     * @param int $timeout
     * @param string $timeoutAction ignore|destroy (destroy = hard stop)
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function restart(
        $uuid,
        $type = 'soft',
        $timeout = 60,
        $timeoutAction = 'ignore'
    ) {
        $params['restart_server'] = [
            'stop_type' => $type,
            'timeout_action' => $timeoutAction,
        ];

        if ($timeout) {
            $params['restart_server']['timeout'] = $timeout;
        }

        return $this->executeAction($uuid, 'restart', $params);
    }

    /**
     * https://www.upcloud.com/api/8-servers/#modify-server
     *
     * @param $uuid
     * @param array $options
     *
     * @return ServerEntity
     */
    public function modify($uuid, array $options)
    {
        $options['server'] = $options;

        $result = $this->adapter->put(sprintf('%s/server/%s', $this->endpoint, $uuid), $options);

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }

    /**
     * https://www.upcloud.com/api/8-servers/#delete-server
     *
     * @param string $uuid
     *
     * @throws HttpException
     */
    public function delete($uuid)
    {
        $this->adapter->delete(sprintf('%s/server/%s', $this->endpoint, $uuid));
    }

    /**
     * Helper function to execute an action on a server.
     *
     * @param string $uuid
     * @param string $action
     * @param array $options
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    private function executeAction($uuid, $action, array $options = [])
    {
        $result = $this->adapter->post(sprintf('%s/server/%s/%s', $this->endpoint, $uuid, $action), $options);

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }
}
