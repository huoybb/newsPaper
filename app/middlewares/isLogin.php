<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/15
 * Time: 18:25
 */

namespace App\middlewares;


class isLogin implements middlewareInterface
{

    public function isValid()
    {
        if(\AuthFacade::user()) return true;
        
        redirect(['for'=>'login']);
        return false;
    }
}