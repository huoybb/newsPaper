<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/10
 * Time: 6:16
 */

namespace App\forms;


use App\myPlugins\myForm;

class tagForm extends myForm
{
    protected $exludedFields = [
        'created_at',
        'updated_at',
        'id',
//        'password',
//        'remember_token'
    ];
}