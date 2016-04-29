<?php

/*
 * This file is part of the UpCloud library.
 *
 * (c) Shirleyson Kaisser <skaisser@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UpCloud\Entity;

/**
 * @author Shirleyson Kaisser <skaisser@gmail.com>
 */
final class FloatingIp extends AbstractEntity
{
    /**
     * @var string
     */
    public $ip;

    /**
     * @var Droplet|null
     */
    public $droplet;

    /**
     * @var Region
     */
    public $region;

    /**
     * @param array $parameters
     */
    public function build(array $parameters)
    {
        parent::build($parameters);

        foreach ($parameters as $property => $value) {
            if ('droplet' === $property && is_object($value)) {
                $this->droplet = new Droplet($value);
            }

            if ('region' === $property && is_object($value)) {
                $this->region = new Region($value);
            }
        }
    }
}
