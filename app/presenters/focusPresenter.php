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

    public function url()
    {
        return \UrlFacade::get(['for'=>'focus.show','focus'=>$this->entity->id]);
    }
    public function type()
    {
        return '关注';
    }
    public function title()
    {
        return $this->entity->title;
    }



       

}