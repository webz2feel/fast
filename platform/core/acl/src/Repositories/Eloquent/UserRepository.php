<?php

namespace Fast\ACL\Repositories\Eloquent;

use Fast\ACL\Repositories\Interfaces\UserInterface;
use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;

class UserRepository extends RepositoriesAbstract implements UserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUniqueUsernameFromEmail($email)
    {
        $emailPrefix = substr($email, 0, strpos($email, '@'));
        $username = $emailPrefix;
        $offset = 1;
        while ($this->getFirstBy(['username' => $username])) {
            $username = $emailPrefix . $offset;
            $offset++;
        }

        $this->resetModel();

        return $username;
    }
}
