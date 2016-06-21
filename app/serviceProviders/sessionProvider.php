<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 12:21
 */

namespace App\serviceProviders;

use App\myPlugins\myProvider;
use Phalcon\Session\Adapter\Files as SessionAdapter;

class sessionProvider extends myProvider
{

    public function register($name)
    {
        /**
         * Start the session the first time some component request the session service
         */
        $this->di->setShared($name, function () {
            $session = new SessionAdapter();
            $session->start();

            return $session;
        });
    }
}