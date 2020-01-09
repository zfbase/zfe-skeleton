<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Editors', 'dbh');

/**
 * Base for Пользователи
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id Идентификатор
 * @property string $second_name Фамилия
 * @property string $first_name Имя
 * @property string $middle_name Отчество
 * @property string $email Эл. почта
 * @property string $phone Телефон
 * @property string $login Логин
 * @property string $password Пароль
 * @property string $password_salt Соль пароля
 * @property integer $request_password_change Требование смены пароля
 * @property string $role Роль
 * @property string $department Подразделение
 * @property string $comment Комментарий
 * @property Doctrine_Collection $History
 * @property Doctrine_Collection $Files
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseEditors extends AbstractRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('editors');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'autoincrement' => true,
             'comment' => 'Идентификатор',
             'length' => '4',
             ));
        $this->hasColumn('second_name', 'string', 125, array(
             'type' => 'string',
             'comment' => 'Фамилия',
             'length' => '125',
             ));
        $this->hasColumn('first_name', 'string', 125, array(
             'type' => 'string',
             'comment' => 'Имя',
             'length' => '125',
             ));
        $this->hasColumn('middle_name', 'string', 125, array(
             'type' => 'string',
             'comment' => 'Отчество',
             'length' => '125',
             ));
        $this->hasColumn('email', 'string', 125, array(
             'type' => 'string',
             'comment' => 'Эл. почта',
             'length' => '125',
             ));
        $this->hasColumn('phone', 'string', 125, array(
             'type' => 'string',
             'comment' => 'Телефон',
             'length' => '125',
             ));
        $this->hasColumn('login', 'string', 31, array(
             'type' => 'string',
             'comment' => 'Логин',
             'length' => '31',
             ));
        $this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'comment' => 'Пароль',
             'length' => '255',
             ));
        $this->hasColumn('password_salt', 'string', 31, array(
             'type' => 'string',
             'comment' => 'Соль пароля',
             'length' => '31',
             ));
        $this->hasColumn('request_password_change', 'integer', 1, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'default' => '0',
             'comment' => 'Требование смены пароля',
             'length' => '1',
             ));
        $this->hasColumn('role', 'string', 31, array(
             'type' => 'string',
             'comment' => 'Роль',
             'length' => '31',
             ));
        $this->hasColumn('department', 'string', 125, array(
             'type' => 'string',
             'comment' => 'Подразделение',
             'length' => '125',
             ));
        $this->hasColumn('comment', 'string', 1000, array(
             'type' => 'string',
             'comment' => 'Комментарий',
             'length' => '1000',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('History', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Files', array(
             'local' => 'id',
             'foreign' => 'creator_id'));

        $zfe_model_template_basezfefields0 = new ZFE_Model_Template_BaseZfeFields();
        $this->actAs($zfe_model_template_basezfefields0);
    }
}