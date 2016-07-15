<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/15
 * Time: 18:23
 */

namespace App\middlewares;


interface middlewareInterface
{
    /**
     * 返回true或者false，如果是false，则需要在返回前设置response的redirect转向
     * @return mixed
     */
    public function isValid();
}