<?php

/**
 * https://www.upcloud.com/api/3-accounts/
 */

namespace UpCloud\Api;

use UpCloud\Entity\Account as AccountEntity;

class Account extends AbstractApi
{
    /**
     * https://www.upcloud.com/api/3-accounts/#get-account-information
     *
     * @return AccountEntity
     */
    public function getAccountInformation()
    {
        $result = $this->adapter->get(sprintf('%s/account', $this->endpoint));

        $result = json_decode($result);

        return new AccountEntity($result->account);
    }
}
