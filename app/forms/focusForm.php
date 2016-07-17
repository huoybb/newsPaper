<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/10
 * Time: 22:33
 */

namespace App\forms;


use App\myPlugins\myForm;

class focusForm extends myForm
{
    protected $only = [
        'title',
        'description',
        'Y',
    ];
}