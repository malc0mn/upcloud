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

use UpCloud\Entity\Account as AccountEntity;

/**
 * @author Shirleyson Kaisser <skaisser@gmail.com>
 */
class Account extends AbstractApi
{
    /**
     * @return AccountEntity
     */
    public function getAccountInformation()
    {
        $account = $this->adapter->get(sprintf('%s/account', $this->endpoint));

        $account = json_decode($account);

        return new AccountEntity($account->account);
    }
}
