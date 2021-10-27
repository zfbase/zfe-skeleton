<?php

// Класс исполнителя для отправки почты
class Helper_Task_Performer_SendEmail extends Helper_Task_Performer
{
    public function perform(int $relatedItemId): Helper_Task_Performer
    {
        $email = Emails::find($relatedItemId);
        if ($email) {
            $mailer = new Helper_Mailer();
            try {
                $mailer->send($email);
            } catch (Zend_Mail_Exception $e) {
                throw new Helper_Task_Performer_Exception('Не удалось отправить письмо: ' . $e->getMessage(), 1, $e);
            }
        } else {
            throw new Helper_Task_Performer_Exception('Не удалось найти письмо с ID:' . $relatedItemId);
        }

        return $this;
    }
}
