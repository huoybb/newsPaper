<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/12
 * Time: 8:42
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use Phalcon\Http\Response\Cookies;

class cookiesProvider  extends myProvider
{

    public function register($name)
    {
        $this->di->setShared($name,function(){
            $cookies = new Cookies();
//            $cookies->useEncryption(false);
            return $cookies;
        });
    }
}