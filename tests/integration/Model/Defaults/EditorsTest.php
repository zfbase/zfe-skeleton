<?php

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
