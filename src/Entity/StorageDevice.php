<?php

/**
 * https://www.upcloud.com/api/9-storages/#attach-storage
 */

namespace UpCloud\Entity;

final class StorageDevice extends AbstractEntity
{
    /**
     * The type of the attached storage.
     *
     * @var string disk|cdrom
     */
    public $type;

    /**
     * The address where the storage device is attached on the server.
     *
     * @var string ide[01]:[01] | scsi:0:[0-7] | virtio:[0-7]
     */
    public $address;

    /**
     * The UUID of the storage to attach.
     *
     * @var string A valid storage UUID (required if type is 'disk')
     */
    public $storage;
}
