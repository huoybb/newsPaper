<?php

class IssuesController extends \App\myPlugins\myController
{

    public function indexAction()
    {

    }
    public function showAction(Issues $issue)
    {
//        $issue->delete();
//        set_time_limit(0);
//        $issue->getPagesFromWeb();
        $this->view->issue = $issue;
    }

    public function deleteAction(Issues $issue)
    {
        $issue->delete();
        $this->redirectByRoute(['for'=>'home']);
    }


}

