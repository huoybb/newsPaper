<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/13
 * Time: 21:49
 */

namespace App\forms;


use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class loginForm extends Form
{
    public function initialize()
    {
        $this->add(new Text('name'));
        $this->add(new Password('password'));
        $this->add(new Check('remember'));
        $this->add(new Submit('Login'));
    }

}