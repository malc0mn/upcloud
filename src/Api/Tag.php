<?php

/**
 * https://www.upcloud.com/api/12-tags/
 */

namespace UpCloud\Api;

use UpCloud\Entity\Server as ServerEntity;
use UpCloud\Entity\Tag as TagEntity;
use UpCloud\Exception\HttpException;

class Tag extends AbstractApi
{
    /**
     * https://www.upcloud.com/api/12-tags/#list-existing-tags
     *
     * @return TagEntity[]
     */
    public function getAll($uuid)
    {
        $result = $this->adapter->get(sprintf('%s/tag', $this->endpoint, $uuid));

        $result = json_decode($result);

        return array_map(function ($tag) {
            return new TagEntity($tag);
        }, $result->tags->tag);
    }

    /**
     * https://www.upcloud.com/api/12-tags/#create-a-new-tag
     *
     * @param string $name The tag name.
     * @param string $description The tag description.
     * @param array $servers An array of server UUIDs to apply the tag to.
     *
     * @return TagEntity
     */
    public function create($name, $description, array $servers = []) {
        $data['tag'] = [
            'name' => $name,
            'description' => $description,
        ];

        if (!empty($servers)) {
            $data['tag']['servers']['server'] = $servers;
        }

        $result = $this->adapter->post(sprintf('%s/tag', $this->endpoint), $data);

        $result = json_decode($result);

        return new TagEntity($result->tag);
    }

    /**
     * https://www.upcloud.com/api/12-tags/#modify-existing-tag
     *
     * @param string $oldName The tag name to modify.
     * @param string $newName The new tag name.
     * @param string $description The tag description.
     * @param array $servers An array of server UUIDs to apply the tag to.
     *
     * @return TagEntity
     */
    public function modify($oldName, $newName, $description, array $servers = []) {
        $data['tag'] = [
            'name' => $newName,
            'description' => $description,
        ];

        if (!empty($servers)) {
            $data['tag']['servers']['server'] = $servers;
        }

        $result = $this->adapter->put(sprintf('%s/tag/%s', $this->endpoint, $oldName), $data);

        $result = json_decode($result);

        return new TagEntity($result->tag);
    }

    /**
     * https://www.upcloud.com/api/12-tags/#delete-tag
     *
     * @param string $name The tag to delete.
     *
     * @throws HttpException
     */
    public function delete($name)
    {
        $this->adapter->delete(sprintf('%s/tag/%s', $this->endpoint, $name));
    }

    /**
     * https://www.upcloud.com/api/12-tags/#assign-tag-to-a-server
     *
     * @param string $uuid The UUID of the server to apply the tags to.
     * @param array $tags An array of tags to apply.
     *
     * @return ServerEntity
     */
    public function assign($uuid, array $tags) {
        $tags = implode(',', $tags);

        $result = $this->adapter->put(sprintf('%s/server/%s/tag/%s', $this->endpoint, $uuid, $tags));

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }

    /**
     * https://www.upcloud.com/api/12-tags/#remove-tag-from-server
     *
     * @param string $uuid The UUID of the server to remove the tags from.
     * @param array $tags An array of tags to remove.
     *
     * @return ServerEntity
     */
    public function untag($uuid, array $tags) {
        $tags = implode(',', $tags);

        $result = $this->adapter->put(sprintf('%s/server/%s/untag/%s', $this->endpoint, $uuid, $tags));

        $result = json_decode($result);

        return new ServerEntity($result->server);
    }
}
