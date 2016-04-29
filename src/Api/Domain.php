<?php

/*
 * This file is part of the UpCloud library.
 *
 * (c) Shirleyson Kaisser <skaisser@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UpCloud\Api;

use UpCloud\Entity\Domain as DomainEntity;
use UpCloud\Exception\HttpException;

/**
 * @author Shirleyson Kaisser <skaisser@gmail.com>
 */
class Domain extends AbstractApi
{
    /**
     * @return DomainEntity[]
     */
    public function getAll()
    {
        $domains = $this->adapter->get(sprintf('%s/domains?per_page=%d', $this->endpoint, 200));

        $domains = json_decode($domains);

        $this->extractMeta($domains);

        return array_map(function ($domain) {
            return new DomainEntity($domain);
        }, $domains->domains);
    }

    /**
     * @param string $domainName
     *
     * @throws HttpException
     *
     * @return DomainEntity
     */
    public function getByName($domainName)
    {
        $domain = $this->adapter->get(sprintf('%s/domains/%s', $this->endpoint, $domainName));

        $domain = json_decode($domain);

        return new DomainEntity($domain->domain);
    }

    /**
     * @param string $name
     * @param string $ipAddress
     *
     * @throws HttpException
     *
     * @return DomainEntity
     */
    public function create($name, $ipAddress)
    {
        $content = ['name' => $name, 'ip_address' => $ipAddress];

        $domain = $this->adapter->post(sprintf('%s/domains', $this->endpoint), $content);

        $domain = json_decode($domain);

        return new DomainEntity($domain->domain);
    }

    /**
     * @param string $domain
     *
     * @throws HttpException
     */
    public function delete($domain)
    {
        $this->adapter->delete(sprintf('%s/domains/%s', $this->endpoint, $domain));
    }
}
