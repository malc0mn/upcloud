<?php

/**
 * https://www.upcloud.com/api/9-storages/
 */

namespace UpCloud\Api;

use UpCloud\Entity\BackupRule;
use UpCloud\Entity\Server as ServerEntity;
use UpCloud\Entity\Storage as StorageEntity;
use UpCloud\Entity\StorageDevice;
use UpCloud\Exception\HttpException;

class Storage extends AbstractApi
{
    /**
     * https://www.upcloud.com/api/9-storages/#list-storages
     *
     * @return StorageEntity[]
     */
    public function getAll($filter = null)
    {
        if ($filter === null) {
            $path = sprintf('%s/storage', $this->endpoint);
        } else {
            $path = sprintf('%s/storage/%s', $this->endpoint, $filter);
        }
        $result = $this->adapter->get($path);

        $result = json_decode($result);

        return array_map(function ($storage) {
            return new StorageEntity($storage);
        }, $result->storages->storage);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#get-storage-details
     *
     * @param string $uuid
     *
     * @throws HttpException
     *
     * @return StorageEntity
     */
    public function getByUniqueId($uuid)
    {
        $result = $this->adapter->get(sprintf('%s/storage/%s', $this->endpoint, $uuid));

        $result = json_decode($result);

        return new StorageEntity($result->storage);
    }

    /**
     * https://www.upcloud.com/api/8-servers/#creating-from-a-template
     *
     * @return StorageEntity[]
     */
    public function getTemplates()
    {
        $result = $this->adapter->get(sprintf('%s/storage/template', $this->endpoint));

        $result = json_decode($result);

        return array_map(function ($storage) {
            return new StorageEntity($storage);
        }, $result->storages->storage);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#create-storage
     *
     * @param string $zone The zone in which the storage will be created, e.g.
     *                     fi-hel1.
     * @param string $size 10-1024 The size of the storage in gigabytes.
     * @param string $title 0-64 characters A short description.
     * @param string $tier hdd|maxiops The storage tier to use.
     * @param BackupRule $backupRule The backup_rule block defines when the
     *                               storage device is backed up automatically.
     *
     * @return StorageEntity
     */
    public function create(
        $zone,
        $size,
        $title,
        $tier = 'hdd',
        BackupRule $backupRule = null
    ) {
        $data['storage'] = [
            'zone' => $zone,
            'size' => $size,
            'title' => $title,
            'tier' => $tier,
        ];

        if ($backupRule !== null) {
            $data['storage']['backup_rule'] = $backupRule->toApiPostData();
        }

        $result = $this->adapter->post(sprintf('%s/storage', $this->endpoint), $data);

        $result = json_decode($result);

        return new StorageEntity($result->storage);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#modify-storage
     *
     * @param string $uuid
     * @param string $size 10-1024 The size of the storage in gigabytes.
     * @param string $title 0-64 characters A short description.
     * @param BackupRule $backupRule The backup_rule block defines when the
     *                               storage device is backed up automatically.
     *
     * @return StorageEntity
     */
    public function modify(
        $uuid,
        $size = null,
        $title = null,
        BackupRule $backupRule = null
    ) {
        $data['storage'] = [];

        if ($size !== null) {
            $data['storage']['size'] = $size;
        }
        if ($title !== null) {
            $data['storage']['title'] = $title;
        }
        if ($backupRule !== null) {
            $data['storage']['backup_rule'] = $backupRule->toApiPostData();
        }

        if (!empty($data['storage'])) {
            $result = $this->adapter->put(sprintf('%s/storage/%s', $this->endpoint, $uuid), $data);

            $result = json_decode($result);

            return new StorageEntity($result->storage);
        } else {
            return null;
        }
    }

    /**
     * https://www.upcloud.com/api/9-storages/#attach-storage
     *
     * @param string $uuid The server to attach the storage to.
     * @param StorageDevice $storageDevice
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function attach($uuid, StorageDevice $storageDevice)
    {
        $data['storage_device'] = $storageDevice->toApiPostData();

        $result = $this->adapter->put(sprintf('%s/server/%s/storage/attach', $this->endpoint, $uuid), $data);

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#detach-storage
     *
     * @param string $uuid The server to detach the storage from.
     * @param string $address
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function detach($uuid, $address)
    {
        $data['storage_device']['address'] = $address;

        $result = $this->adapter->put(sprintf('%s/server/%s/storage/detach', $this->endpoint, $uuid), $data);

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#load-cd-rom
     *
     * @param string $serverUuid The server for which to load the CD-ROM.
     * @param string $storageUuid The UUID of the storage to be loaded in the
     *                            CD-ROM device.
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function cdromLoad($serverUuid, $storageUuid)
    {
        $data['storage_device']['storage'] = $storageUuid;

        $result = $this->adapter->put(sprintf('%s/server/%s/cdrom/load', $this->endpoint, $serverUuid), $data);

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#eject-cd-rom
     *
     * @param string $uuid The server for which to eject the CD-ROM.
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function cdromEject($uuid)
    {
        $result = $this->adapter->put(sprintf('%s/server/%s/cdrom/eject', $this->endpoint, $uuid));

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#clone-storage
     *
     * @param string $uuid The UUID of the storage device to clone.
     * @param string $zone The zone in which the storage will be created, e.g. fi-hel1. See Zones.
     * @param string $title 0-64 characters A short description.
     * @param string $tier hdd|maxiops The storage tier to use. See Storage tiers.
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function cloneStorage($uuid, $zone, $title, $tier = 'hdd') {
        $params['storage'] = [
            'zone' => $zone,
            'title' => $title,
            'tier' => $tier,
        ];
        return $this->executeAction($uuid, 'clone', $params);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#templatize-storage
     *
     * @param string $uuid The UUID of the storage device to templatize.
     * @param string $title 0-64 characters A short description.
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function templatize($uuid, $title) {
        $params['storage'] = [
            'title' => $title,
        ];
        return $this->executeAction($uuid, 'templatize', $params);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#create-backup
     *
     * @param string $uuid The UUID of the storage device to backup.
     * @param string $title 0-64 characters A short description.
     *
     * @throws HttpException
     *
     * @return ServerEntity
     */
    public function createBackup($uuid, $title) {
        $params['storage'] = [
            'title' => $title,
        ];
        return $this->executeAction($uuid, 'backup', $params);
    }

    /**
     * https://www.upcloud.com/api/9-storages/#create-backup
     *
     * @param string $uuid The UUID of the storage device to restore.
     *
     * @throws HttpException
     */
    public function restoreBackup($uuid) {
        $this->adapter->post(sprintf('%s/storage/%s/restore', $this->endpoint, $uuid));
    }

    /**
     * https://www.upcloud.com/api/9-storages/#add-storage-to-favorites
     *
     * @param string $uuid The UUID of the storage device to add to favorites.
     *
     * @throws HttpException
     */
    public function addFavorite($uuid) {
        $this->adapter->post(sprintf('%s/storage/%s/favorite', $this->endpoint, $uuid));
    }

    /**
     * https://www.upcloud.com/api/9-storages/#remove-storage-from-favorites
     *
     * @param string $uuid The UUID of the storage device to add to favorites.
     *
     * @throws HttpException
     */
    public function deleteFavorite($uuid) {
        $this->adapter->delete(sprintf('%s/storage/%s/favorite', $this->endpoint, $uuid));
    }

    /**
     * https://www.upcloud.com/api/9-storages/#delete-storage
     *
     * @param string $uuid
     *
     * @throws HttpException
     */
    public function delete($uuid)
    {
        $this->adapter->delete(sprintf('%s/storage/%s', $this->endpoint, $uuid));
    }

    /**
     * Helper function to execute an action on a storage device.
     *
     * @param string $uuid
     * @param string $action
     *
     * @throws HttpException
     *
     * @return StorageEntity
     */
    private function executeAction($uuid, $action, array $options = [])
    {
        $result = $this->adapter->post(sprintf('%s/storage/%s/%s', $this->endpoint, $uuid, $action), $options);

        $result = json_decode($result);

        return new StorageEntity($result->storage);
    }
}
