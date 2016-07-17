<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/21
 * Time: 4:37
 */

namespace App\presenters;


use App\myPlugins\myPresenter;
use App\myPlugins\myTools;

class pagesPresenter extends myPresenter
{
    public function src()
    {
        return preg_replace('|public|','',$this->entity->src);
    }
    public function title()
    {
        return '参考消息  '.$this->entity->getIssue()->present()->date.' 第'.$this->entity->page_num.'版';
    }

    public function showfileName()
    {
        return basename($this->entity->src);
    }


}