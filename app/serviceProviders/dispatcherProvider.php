<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 12:22
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use RequestFacade;
use ResponseFacade;
use RouterFacade;

class dispatcherProvider extends myProvider
{

    public function register($name)
    {

        $this->di->setShared($name,function(){
            $eventsManager = \EventFacade::getService();
            $eventsManager->attach("dispatch:beforeDispatchLoop", function(Event $event, Dispatcher $dispatcher){
                //模型注入的功能，这里可以很方便的进行 model binding,这里基本上实现了Laravel中的模型绑定的功能了
                return RouterFacade::executeModelBinding($dispatcher);
            });
            $eventsManager->attach('dispatch:beforeExecuteRoute',function(Event $event,Dispatcher $dispatcher){
                return RouterFacade::executeMiddleWareChecking(RequestFacade::getService(), ResponseFacade::getService(),$dispatcher);
            });

            $dispatcher = new Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        });
    }
}