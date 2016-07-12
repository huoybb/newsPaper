<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/27
 * Time: 8:42
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use Phalcon\Crypt;

class cryptProvider extends myProvider
{

    public function register($name)
    {
        $this->di->setShared($name,function(){
            $crypt = new Crypt();
            $crypt->setKey('myCryptKey024025');//需要注意，key的位数，16,24,32，需要注意！
            return $crypt;
        });
    }
}