<?php
/**
 * Created by PhpStorm.
 * User: Dezzpil
 * Date: 28.02.2018
 * Time: 18:01
 */

namespace Tests\Integration;

class UserHelper
{
    const LOGIN = 'tester';

    /**
     * @return null|\Editors
     */
    function getTester() : ?\Editors
    {
        return \Editors::findOneBy('login', static::LOGIN);
    }

    /**
     * @param \Editors $user
     */
    function auth(\Editors $user)
    {
        \Zend_Registry::set('user', (object) [
            'data' => $user,
            //'role' => \Editors::ROLE_ADMIN,
            'role' => 'admin',
            'isAuthorized' => true,
            'displayName' => $user->getShortName(),
            'canSwitchRoles' => true
        ]);
    }
}
