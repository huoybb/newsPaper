<?php
namespace App\myPlugins;
use Phalcon\Di\FactoryDefault;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 11:23
 */
class myDI extends FactoryDefault
{

    public function register($providers, $config = null)
    {
        foreach($providers as $name => $provider){
            $provider = new $provider($this);
            /** @var myProvider $provider */
            $provider->register($name);
        }
    }
}