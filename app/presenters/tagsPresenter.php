<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/11
 * Time: 9:49
 */

namespace App\presenters;


use App\myPlugins\myPresenter;

class tagsPresenter extends myPresenter
{
    public function url()
    {
        return \UrlFacade::get(['for'=>'tags.show','tag'=>$this->entity->id]);
    }
    public function type()
    {
        return '标签';
    }
    public function title()
    {
        return $this->entity->name;
    }



}