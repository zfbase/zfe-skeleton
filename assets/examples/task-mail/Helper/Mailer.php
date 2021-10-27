<?php

// Класс Helper_Mailer, который управляет письмами
class Helper_Mailer
{
    // Запланировать отправку письма
    public function queue(Helper_Mailer_Event $event) : Tasks
    {
        $conn = Doctrine_Manager::connection();
        $conn->beginTransaction();

        // создается объект письма, соотв. событию
        $email = $event->create();

        // создаем нужного исполнителя под задачу
        $performer = new Helper_Task_Performer_SendEmail();

        // планируем задачу для исполнения
        $manager = Helper_Task_Manager::getInstance();
        try {
            $task = $manager->plan($email, $performer);
        } catch (Exception $e) {
            $conn->rollback();
            throw $e;
        }

        $email->task_id = $task->id;
        $email->save();

        $conn->commit();
        return $task;
    }
    
    // Отправить письмо на сервер
    public function send(Emails $email)
    {
        $mail = $this->newMail()
            ->setBodyHtml($email->getBody())
            ->setSubject($email->getSubject());

        foreach ($email->getTo(false) as $editor) {
            $mail->addTo($editor->email, $editor->getFullName());
        }
        foreach ($email->getCopy() as $editor) {
            $mail->addCC($editor->email, $editor->getFullName());
        }

        try {
            $mail->send();
        } catch (Zend_Mail_Exception $e) {
            throw $e;
        }
        $email->markAsSended()->save();
    }
}
