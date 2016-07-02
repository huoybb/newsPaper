<?php

class TagsController extends \App\myPlugins\myController
{

    public function indexAction()
    {
        $this->view->tags = Tags::find();
    }

    public function showAction(Tags $tag)
    {
//        dd($tag->getFocus()->toArray());
        $this->view->mytag = $tag;
    }


}

