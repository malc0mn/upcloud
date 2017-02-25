<?php

namespace UpCloud\Entity;

final class Tag extends AbstractEntity
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $description;

    /**
     * @var array
     */
    public $servers;
}
