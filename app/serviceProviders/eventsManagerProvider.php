<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 17:08
 */

namespace App\serviceProviders;


use App\eventsHandlers\myTestEventHandler;
use App\myPlugins\myEventManager;
use App\myPlugins\myProvider;

class eventsManagerProvider extends myProvider
{

    public function register($name)
    {
        $this->di->setShared($name,function(){
            $eventsManager = new myEventManager();
            $eDomain = \ConfigFacade::getService()->application->eventPrefix;
            $eventsManager->register($eDomain,[
                myTestEventHandler::class,
            ]);
            return $eventsManager;
        });
    }
}