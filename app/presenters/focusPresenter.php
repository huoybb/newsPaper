<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/2
 * Time: 22:05
 */

namespace App\presenters;


use App\myPlugins\myPresenter;

class focusPresenter extends myPresenter
{
    public function getLowerClassName()
    {
        return strtolower(get_class($this->entity));
    }
       

}