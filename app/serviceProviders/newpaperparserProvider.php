<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/22
 * Time: 15:28
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use App\webParser\hqcknet;
use App\webParser\jdqucom;

class newpaperparserProvider extends myProvider
{

    public function register($name)
    {
        $this->di->setShared($name,function(){
//            return new hqcknet();
            return new jdqucom();
        });
    }
}