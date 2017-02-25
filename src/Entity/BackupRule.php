<?php

/**
 * https://www.upcloud.com/api/9-storages/#create-storage
 */

namespace UpCloud\Entity;

final class BackupRule extends AbstractEntity
{
    /**
     * The weekday when the backup is created. If  daily is selected, backups
     * are made every day at the same time.
     *
     * @var string daily|mon|tue|wed|thu|fri|sat|sun
     */
    public $interval;

    /**
     * The time of day when the backup is created.
     *
     * @var string 0000-2359
     */
    public $time;

    /**
     * The number of days before a backup is automatically deleted. The maximum
     * retention period is three years (1095 days).
     *
     * @var int 1-1095
     */
    public $retention;

}
