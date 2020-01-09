<?php

class Console_Command_Tasks extends ZFE_Console_Command_Abstract
{
    protected static $_description = 'Получить список исполнителей задач';

    public static function getName()
    {
        return 'tasks';
    }

    public function execute(array $params = [])
    {
        $table = $this->getHelperBroker()->get('Table');
        $table->setHeaders(['Код задачи', 'Класс исполнителя']);
        $manager = ZFE_Tasks_Manager::getInstance(Zend_Registry::get('config'));
        foreach ($manager->getPerformers() as $code => $performer) {
            $table->addRow([$code, get_class($performer)]);
        }
        $table->render();
    }
}
