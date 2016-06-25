<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/20
 * Time: 21:52
 */

namespace App\presenters;


use App\myPlugins\myPresenter;

class issuesPresenter extends myPresenter
{
    public function title()
    {
        return preg_replace('/.+([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})$/sm', '$1', $this->entity->title);
    }
    public function poster()
    {
        if(preg_match('|^public|',$this->entity->poster)) return preg_replace('|public|','',$this->entity->poster);
        return $this->entity->poster;
    }


}