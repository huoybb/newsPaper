<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 12:19
 */

namespace App\serviceProviders;
use App\myPlugins\myProvider;
use Phalcon\Flash\Session as Flash;

class flashProvider extends myProvider
{

    public function register($name)
    {
        /**
         * Register the session flash service with the Twitter Bootstrap classes
         */
        $this->di->set($name, function () {
            return new Flash(array(
                'error'   => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice'  => 'alert alert-info',
                'warning' => 'alert alert-warning'
            ));
        });
    }
}