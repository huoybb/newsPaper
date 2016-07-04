<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 12:24
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use App\myPlugins\myTools;

class myToolsProvider extends myProvider
{
    public function register($name)
    {
        $this->di->setShared($name,function(){
            return new myTools();
        });
    }
}