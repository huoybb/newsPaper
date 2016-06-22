<?php

class IssuesController extends \App\myPlugins\myController
{

    public function indexAction()
    {

    }
    public function showAction(Issues $issue)
    {
//        $issue->delete();
        $this->view->issue = $issue;
    }

}

