<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 12:16
 */

namespace App\serviceProviders;
use App\myPlugins\myProvider;
use Phalcon\Mvc\Model\MetaData\Memory;

class modelsMetadataProvider extends myProvider
{

    public function register($name)
    {

        /**
         * If the configuration specify the use of metadata adapter use it or use memory otherwise
         */
        $this->di->setShared($name, function () {
            return new Memory();
        });
    }
}