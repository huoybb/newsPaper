<?php
namespace App\models;
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/12
 * Time: 9:12
 */

use App\myPlugins\myModel;

trait belongToUserTrait
{
    public function user()
    {
        /** @var myModel $this */
        return \Users::findFirst($this->user_id);
    }

}