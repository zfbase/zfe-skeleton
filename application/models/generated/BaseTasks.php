<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Tasks', 'dbh');

/**
 * BaseTasks
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id Идентификатор
 * @property timestamp $created_at Дата добавления
 * @property timestamp $scheduled_at Плановое время запуска
 * @property timestamp $done_at Окончание исполнения
 * @property string $performer_code Код исполнителя
 * @property integer $related_id Объект исполнения
 * @property integer $state Состояние
 * @property string $errors Ошибки
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTasks extends AbstractRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tasks');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'comment' => 'Идентификатор',
             'length' => '4',
             ));
        $this->hasColumn('created_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'default' => 'current_timestamp()',
             'notnull' => true,
             'comment' => 'Дата добавления',
             'length' => '25',
             ));
        $this->hasColumn('scheduled_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'comment' => 'Плановое время запуска',
             'length' => '25',
             ));
        $this->hasColumn('done_at', 'timestamp', 25, array(
             'type' => 'timestamp',
             'comment' => 'Окончание исполнения',
             'length' => '25',
             ));
        $this->hasColumn('performer_code', 'string', 63, array(
             'type' => 'string',
             'notnull' => true,
             'comment' => 'Код исполнителя',
             'length' => '63',
             ));
        $this->hasColumn('related_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'comment' => 'Объект исполнения',
             'length' => '4',
             ));
        $this->hasColumn('state', 'integer', 1, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'default' => '0',
             'comment' => 'Состояние',
             'length' => '1',
             ));
        $this->hasColumn('errors', 'string', null, array(
             'type' => 'string',
             'comment' => 'Ошибки',
             'length' => '1000',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $nestedset0 = new Doctrine_Template_NestedSet(array(
             'hasManyRoots' => true,
             'rootColumnName' => 'root_id',
             ));
        $this->actAs($nestedset0);
    }
}