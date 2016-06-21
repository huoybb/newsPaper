<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 17:29
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;

class configProvider extends myProvider
{

    public function register($name)
    {
        $this->di->setShared($name,function(){
            return include APP_PATH . "/app/config/config.php";
        });
    }
}