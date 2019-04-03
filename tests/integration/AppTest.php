<?php

namespace Tests\integration;

/**
 * Class AppTest
 * Расширяем его повторяющейся функциональностью для тестирования приложения
 *
 * @package Tests\integration
 */
abstract class AppTest extends ModelsTest {

    /**
     * @var \Editors|null
     */
    protected $user = null;

    /**
     * @throws \Exception
     */
    function setUp()
    {
        parent::setUp();

        $user = \Editors::findOneBy('login', 'tester');
        if (!$user) {
            throw new \Exception('В приложении не существует пользователя с логином tester - тестирование невозможно');
        }

        \ZFE_Auth_Editor::getInstance()->set($user);
        $this->user = $user;

        // Делаем как в бутстрапе для каждого теста
        \Zend_Registry::set('user', (object) [
            'data' => $user,
            'role' => \Editors::ROLE_ADMIN,
            'isAuthorized' => true,
            'displayName' => $user->getShortName(),
            'canSwitchRoles' => true,
            'noticeDetails' => 1,
        ]);
    }

    /**
     * @return \Editors
     */
    public function getUser() : \Editors
    {
        return $this->user;
    }
}
