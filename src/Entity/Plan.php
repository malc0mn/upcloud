<?php

namespace UpCloud\Entity;

final class Plan extends AbstractEntity
{
   /**
     * @var int
     */
    public $coreNumber;


    /**
     * @var int
     */
    public $memoryAmount;


    /**
     * @var string
     */
    public $name;


    /**
     * @var int
     */
    public $publicTrafficOut;


    /**
     * @var int
     */
    public $storageSize;


    /**
     * @var string
     */
    public $storageTier;
}
