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

    public function updateAction(Issues $issue)
    {
        set_time_limit(0);
        $issue->updateFromWeb();
        $this->redirectBack();
    }

    public function showPageAction(Issues $issue,Pages $page)
    {
//        if(! $page->src) $page->refreshPicFromWeb();
//        dd($page);
//        dd($issue);
        $this->view->page = $page;
        $this->view->issue = $issue;
    }




}

