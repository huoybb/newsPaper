<?php
use App\myPlugins\myFacade;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/26
 * Time: 7:42
 */
class ConfigFacade extends myFacade
{
    public static function getFacadeAccessor()
    {
        return 'config';
    }

    public static function get($name){
        return static::getService()->get('application')->{$name};
    }
}