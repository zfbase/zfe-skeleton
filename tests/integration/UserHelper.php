<?php

namespace Tests\Integration;

class UserHelper
{
    const LOGIN = 'tester';

    /**
     * @return null|\Editors
     */
    public function getTester(): ?\Editors
    {
        return \Editors::findOneBy('login', static::LOGIN);
    }

    /**
     * @param \Editors $user
     */
    public function auth(\Editors $user)
    {
        \Zend_Registry::set('user', (object) [
            'data' => $user,
            //'role' => \Editors::ROLE_ADMIN,
            'role' => 'admin',
            'isAuthorized' => true,
            'displayName' => $user->getShortName(),
            'canSwitchRoles' => true,
        ]);
    }
}
