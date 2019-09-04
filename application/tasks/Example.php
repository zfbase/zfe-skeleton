<?php


class Task_Example extends ZFE_Tasks_Performer
{
    public function perform(int $relatedItemId)
    {
        $task = Tasks::find($relatedItemId);
        var_dump($task->toArray(0));
    }
}