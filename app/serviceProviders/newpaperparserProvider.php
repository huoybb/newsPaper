<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/22
 * Time: 15:28
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use App\webParser\abbaocn;
use App\webParser\hqcknet;
use App\webParser\jdqucom;
use App\webParser\parserManager;

class newpaperparserProvider extends myProvider
{

    protected $parsers = [
        'http://www.hqck.net/'  => hqcknet::class,
        'http://www.abbao.cn/'  => abbaocn::class,
        'http://www.jdqu.com'   => jdqucom::class,
    ];

    public function register($name)
    {
        $parsers = $this->parsers;
        $this->di->setShared($name,function() use($parsers) {
            return new parserManager($parsers);
        });
    }
}