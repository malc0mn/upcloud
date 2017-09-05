<?php

namespace UpCloud\Api;

use UpCloud\Adapter\AdapterInterface;

abstract class AbstractApi
{
    /**
     * @var string
     */
    const ENDPOINT = 'https://api.upcloud.com/1.2';

    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @param AdapterInterface $adapter
     * @param string|null      $endpoint
     */
    public function __construct(AdapterInterface $adapter, $endpoint = null)
    {
        $this->adapter = $adapter;
        $this->endpoint = $endpoint ?: static::ENDPOINT;
    }

    /**
     * Return new assoc array that uses $propertyForKey as key.
     *
     * @param array  $array
     * @param string $propertyForKey
     * @return array
     */
    protected function array_map_keys(array $array, $propertyForKey) {
        $tempArray = [];
        foreach($array as $value){
            $tempArray[$value->$propertyForKey] = $value;
        }
        return $tempArray;
    }

}
