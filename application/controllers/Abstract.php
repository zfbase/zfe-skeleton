<?php

/**
 * Базовый контроллер
 */
abstract class Controller_Abstract extends ZFE_Controller_Abstract
{
    /**
     * @return ZFE_Controller_Action_Helper_Notices
     */
    protected function getNotices()
    {
        return $this->_helper->Notices;
    }
}
