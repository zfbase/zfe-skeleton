<?php
/**
 * Created by PhpStorm.
 * User: dezzpil
 * Date: 19.03.19
 * Time: 17:29
 */

namespace Tests\integration\Model\Defaults;

use Tests\integration\AppTest;

class EditorsTest extends AppTest
{
    public function testFromArray()
    {
        $editor = new \Editors;
        $editor->login = 'test';
        $editor->setPassword('test');
        $editor->save();

        $this->assertTrue($editor->exists());
        $this->assertNotNull($editor->id);
        $this->assertNotContains('password', $editor->toArray(false));
    }
}
