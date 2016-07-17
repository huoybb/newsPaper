<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/17
 * Time: 15:55
 */

namespace App\forms;


use App\myPlugins\myForm;

class commentForm extends myForm
{
    protected $only = ['content'];
}