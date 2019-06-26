<?php


class ItemsController extends Controller_AbstractResource
{
    /**
     * Класс модели основного объекта.
     *
     * @var string
     */
    protected static $_modelName = Items::class;

    public function editAction($redirectUrl = null, array $formOptions = [])
    {
        parent::editAction($redirectUrl, $formOptions);
    }

}