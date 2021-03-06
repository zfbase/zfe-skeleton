<?php

namespace Tests\integration\Tasks;

use Tests\integration\AppTest;

class ManagerTest extends AppTest
{
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        // удалим все что оказалось в дампе, чтобы не мешалось
        \Tasks::findAll()->delete();
    }

    public function testNoSectionInConfig()
    {
        $config = new \Zend_Config([]);
        $this->expectException(\ZFE_Tasks_Exception::class);

        \ZFE_Tasks_Manager::getInstance($config);
    }

    public function testNoPerformersInConfig()
    {
        $config = new \Zend_Config(['task' => []]);
        $this->expectException(\ZFE_Tasks_Exception::class);

        \ZFE_Tasks_Manager::getInstance($config);
    }

    public function testPlanTask()
    {
        $manager = \ZFE_Tasks_Manager::getInstance();
        $performer = new \ZFE_Tasks_Performer_Stub;
        $task = $manager->plan($this->getUser(), $performer);

        $this->assertInstanceOf(\Tasks::class, $task);
        $this->assertEquals($task->getRelatedId(), $this->getUser()->id);

        $sameTask = $manager->plan($this->getUser(), $performer);
        $this->assertEquals($sameTask->id, $task->id);

        $performer = new \ZFE_Tasks_Performer_ErrorStub;
        $differentTask = $manager->plan($this->getUser(), $performer);
        $this->assertNotEquals($differentTask->id, $task->id);
    }

    public function testPlanAndFinish()
    {
        $manager = \ZFE_Tasks_Manager::getInstance();
        $performer = new \ZFE_Tasks_Performer_Stub;
        $task = $manager->plan($this->getUser(), $performer);
        $task = $manager->finish($task);

        $this->assertEquals($task->getState(), \ZFE_Tasks_Manager::STATE_DONE);
    }

    public function testPlanAndFindToDoTask()
    {
        $manager = \ZFE_Tasks_Manager::getInstance();

        // создадим задачу, которую предстоит найти
        $performer = new \ZFE_Tasks_Performer_Stub;
        $manager->plan($this->getUser(), $performer);

        // найдем
        $tasks = $manager->findAllToDo();
        $this->assertInstanceOf(\Doctrine_Collection_OnDemand::class, $tasks);
        $this->assertNotNull($tasks->current());

        // задача одна
        $tasks->next();
        $this->assertFalse($tasks->current());
    }

    public function testManageTask()
    {
        $manager = \ZFE_Tasks_Manager::getInstance();

        // создадим задачу, которую предстоит найти
        $performer = new \ZFE_Tasks_Performer_Stub;
        $manager->plan($this->getUser(), $performer);

        // и выполнить
        $tasks = $manager->findAllToDo();
        $manager->manage($tasks);

        // проверим что все выполнено
        $tasks = $manager->findAllToDo();
        $this->assertInstanceOf(\Doctrine_Collection_OnDemand::class, $tasks);
        $this->assertFalse($tasks->current());
    }

    public function testManageTaskNotDone()
    {
        $manager = \ZFE_Tasks_Manager::getInstance();

        // создадим задачу, которую предстоит найти и выполнить
        // используя исполнителя, который только жалуется и ничего не делает
        $performer = new \ZFE_Tasks_Performer_ErrorStub;
        $manager->plan($this->getUser(), $performer);
        $manager->manage($manager->findAllToDo());

        // проверим что ничего не выполнено
        $tasks = $manager->findAllToDo();
        $this->assertInstanceOf(\Doctrine_Collection_OnDemand::class, $tasks);
        $this->assertInstanceOf(\Tasks::class, $tasks->current());
    }

    public function testRevisionTask()
    {
        $manager = \ZFE_Tasks_Manager::getInstance();

        // создадим задачу, которую предстоит найти и выполнить
        $performer = new \ZFE_Tasks_Performer_ErrorStub;
        $manager->plan($this->getUser(), $performer);

        // выполним
        $manager->manage($manager->findAllToDo());

        // проверим что ничего не выполнено
        $tasks = $manager->findAllToDo();

        foreach ($tasks as $task) {
            $revisioned = $manager->revision($task);
            $this->assertNotEquals($task->id, $revisioned->id);
        }
    }

    public function testFindRevisionedTask()
    {
        $manager = \ZFE_Tasks_Manager::getInstance();

        // создадим задачу, которую предстоит найти и выполнить
        $performer = new \ZFE_Tasks_Performer_ErrorStub;
        $manager->plan($this->getUser(), $performer);

        // выполним
        $manager->manage($manager->findAllToDo());

        // проверим что ничего не выполнено
        $tasks = $manager->findAllToDo(10, false);
        $this->assertEquals(1, $tasks->count());
        foreach ($tasks as $task) {
            /** @var \Tasks $task */
            // создаем задачу на доработку
            $revisioned1 = $manager->revision($task);
        }
        $this->assertEquals(1, $tasks->count());

        // найдем дерево, пока 0 элементов
        $collection = $manager->findAllRevisionsFor($revisioned1);
        $this->assertInstanceOf(\Doctrine_Collection::class, $collection);
        $this->assertCount(1, $collection);

        // повторим, ожидаем уже 2 записи в иерархии данных
        $tasks = $manager->findAllToDo(10, false);
        $this->assertEquals(1, $tasks->count());
        foreach ($tasks as $task) {
            /** @var \Tasks $task */
            // создаем задачу на доработку еще раз
            // (ошибок нет, так как не было выполнения)
            $revisioned2 = $manager->revision($task, true);
        }

        // найдем дерево, теперь уже 2 элемента
        $collection = $manager->findAllRevisionsFor($revisioned2);
        $this->assertInstanceOf(\Doctrine_Collection::class, $collection);
        $this->assertEquals(2, $collection->count());
    }
}
