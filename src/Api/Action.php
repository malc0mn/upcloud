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

use UpCloud\Entity\Action as ActionEntity;

/**
 * @author Shirleyson Kaisser <skaisser@gmail.com>
 */
class Action extends AbstractApi
{
    /**
     * @return ActionEntity[]
     */
    public function getAll()
    {
        $actions = $this->adapter->get(sprintf('%s/actions?per_page=%d', $this->endpoint, 200));

        $actions = json_decode($actions);

        $this->extractMeta($actions);

        return array_map(function ($action) {
            return new ActionEntity($action);
        }, $actions->actions);
    }

    /**
     * @param int $id
     *
     * @return ActionEntity
     */
    public function getById($id)
    {
        $action = $this->adapter->get(sprintf('%s/actions/%d', $this->endpoint, $id));

        $action = json_decode($action);

        $this->meta = null;

        return new ActionEntity($action->action);
    }
}
