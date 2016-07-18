<?php
namespace App\presenters;


use App\myPlugins\myPresenter;
use App\serviceProviders\urlProvider;

class columnsPresenter extends myPresenter
{
    public function title()
    {
        return '栏目：'.$this->entity->title;
    }

}