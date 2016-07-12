<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/12
 * Time: 20:31
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use Phalcon\Security;

class securityProvider extends myProvider
{
    //需要注意，password的位数至少是60位，否则mysql容易出现截断的
    public function register($name)
    {
        $this->di->setShared($name,function(){
            $security = new Security();
            // Set the password hashing factor to 12 rounds
            $security->setWorkFactor(12);
            return $security;
        });
    }
}