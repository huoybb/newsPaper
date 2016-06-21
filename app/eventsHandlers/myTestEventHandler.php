<?php
namespace App\eventsHandlers;
use App\events\myTestEvent;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/31
 * Time: 9:34
 */
class myTestEventHandler
{
    public function myTestEvent($e,myTestEvent $event)
    {
        var_dump($event->getData());
    }


}