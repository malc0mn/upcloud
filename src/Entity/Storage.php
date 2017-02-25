<?php

/**
 * https://www.upcloud.com/api/9-storages/#create-storage
 */

namespace UpCloud\Entity;

final class Storage extends AbstractEntity
{
    /**
     * @var string
     */
    public $access;

    /**
     * @var BackupRule
     */
    public $backupRule;

    /**
     * @var array
     */
    public $backups;

    /**
     * @var int
     */
    public $license;

    /**
     * @var array
     */
    public $servers;

    /**
     * @var int
     */
    public $size;

    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $tier;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $uuid;

    /**
     * @var string
     */
    public $zone;
}
