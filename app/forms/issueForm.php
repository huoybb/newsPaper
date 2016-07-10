<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/1
 * Time: 13:26
 */

namespace App\forms;


use App\myPlugins\myForm;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class issueForm extends myForm
{
    protected $exludedFields = [
        'created_at',
        'updated_at',
        'id',
        'pages',
        'newspaper_id',
        'title',
        'status',
    ];

}