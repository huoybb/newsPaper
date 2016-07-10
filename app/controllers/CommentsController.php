<?php

class CommentsController extends \App\myPlugins\myController
{

    public function indexAction()
    {
        $comments = Comments::find(['limit'=>10,'order'=>'id DESC']);
        dd($comments->toArray());
    }

}

