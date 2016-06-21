<?php
namespace App\myPlugins;
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 12:02
 */
abstract class myProvider
{
    protected $di;

    /**
     * routerProvider constructor.
     * @param $di
     */
    public function __construct(myDI $di)
    {
        $this->di = $di;
    }
    abstract public function register($name);

}