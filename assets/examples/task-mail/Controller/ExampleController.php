<?php

class ExampleController extends ZFE_Abstract_Controller
{
    // Экшн, где создается почтовое событие и вызывается постановка задачи на отправку
    public function registerAction()
    {
        $item->status = 10;
        $item->save();
        $this->getNotices()->ok('ИК зарегистрирована!');

        $mailer = new Helper_Mailer;
        $mailerEvent = new Helper_Mailer_Event_Registered($item);
        $mailer->queue($mailerEvent);

        $this->getNotices()->ok('Сообщение о регистрации отправлено пользователю!');
        $this->redirect($item->getEditUrl());
    }
}
