<?php

namespace UpCloud\Entity;
use ReflectionProperty;

abstract class AbstractEntity
{
    /**
     * @param \stdClass|array|null $parameters
     */
    public function __construct($parameters = null)
    {
        if (!$parameters) {
            return;
        }

        if ($parameters instanceof \stdClass) {
            $parameters = get_object_vars($parameters);
        }

        $this->build($parameters);
    }

    /**
     * @param array $parameters
     */
    public function build(array $parameters)
    {
        foreach ($parameters as $property => $value) {
            $property = static::convertToCamelCase($property);

            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @param string|null $date DateTime string
     *
     * @return string|null DateTime in ISO8601 format
     */
    protected static function convertDateTime($date)
    {
        if (!$date) {
            return;
        }

        $date = new \DateTime($date);
        $date->setTimezone(new \DateTimeZone(date_default_timezone_get()));

        return $date->format(\DateTime::ISO8601);
    }

    /**
     * @param string $str Snake case string
     *
     * @return string Camel case string
     */
    protected static function convertToCamelCase($str)
    {
        $callback = function ($match) {
            return strtoupper($match[2]);
        };

        return lcfirst(preg_replace_callback('/(^|_)([a-z])/', $callback, $str));
    }

    /**
     * @return array
     */
    public function toApiPostData()
    {
        $array = [];

        $reflect = new \ReflectionClass($this);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($properties as $property) {
            $value = $property->getValue($this);

            // Do not post null values to the API.
            if ($value !== null) {
                $name = $property->getName();
                // Convert camelCase to snake_case.
                $snakeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $name));
                $array[$snakeName] = $value;
            }
        }

        return $array;
    }
}
