<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 12:05
 */

namespace App\serviceProviders;

use App\myPlugins\myProvider;
use ConfigFacade;
use Phalcon\Mvc\Url as UrlResolver;


class urlProvider extends myProvider
{

    public function register($name)
    {
        /**
         * The URL component is used to generate all kind of urls in the application
         */
        $this->di->setShared($name, function () {
            $url = new UrlResolver();
            $url->setBaseUri(ConfigFacade::get('baseUri'));
            return $url;
        });
    }
}