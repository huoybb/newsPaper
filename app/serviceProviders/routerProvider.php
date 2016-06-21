<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 11:33
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;

class routerProvider extends myProvider
{

    public function register($name)
    {
        $this->di->setShared($name,function(){
            return include \ConfigFacade::get('configDir').'routes.php';
        });
    }
}