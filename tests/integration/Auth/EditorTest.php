<?php
/**
 * Created by PhpStorm.
 * User: dezzpil
 * Date: 03.04.19
 * Time: 18:12
 */

namespace Tests\integration\Auth;

use Tests\integration\AppTest;

class EditorTest extends AppTest
{
    public function testGetId()
    {
        $id = \ZFE_Auth_Editor::getInstance()->getId();
        $this->assertEquals($this->getUser()->id, $id);
    }

    public function testGet()
    {
        $editor = \ZFE_Auth_Editor::getInstance()->get();
        $this->assertEquals($this->getUser(), $editor);
    }

    public function testClear()
    {
        $authed = \ZFE_Auth_Editor::getInstance();

        $id = $authed->getId();
        $this->assertEquals($this->getUser()->id, $id);

        $authed->clear();

        $this->expectException(\Exception::class);
        $authed->getId();
    }

    public function testSet()
    {
        $user = new \Editors;
        $user->setPassword('qwerty');
        $user->login = 'new';
        $user->second_name = 'Demo';
        $user->first_name = 'User';
        $user->save();

        $authed = \ZFE_Auth_Editor::getInstance();
        $authed->set($user);

        $this->assertNotEquals($this->getUser()->id, $authed->getId());
    }

}
