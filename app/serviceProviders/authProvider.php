<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/12
 * Time: 8:47
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use App\myPlugins\myAuth;

class authProvider extends myProvider
{

    public function register($name)
    {
        $this->di->setShared($name,function(){
            //奇怪，这里的this是Di这个对象，看看怎么回事，也类似javascript一样吗？
            $auth = (new myAuth())->setDI($this)->init();
            return $auth;
        });
    }
}