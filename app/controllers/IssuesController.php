<?php

class IssuesController extends \App\myPlugins\myController
{

    public function indexAction($page=1)
    {
        $this->view->page = $this->getPaginator(Issues::find(['order'=>'date DESC,id DESC']),15,$page);

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

    public function showPageAction(Issues $issue,$page_num)
    {
//        if(! $page->src) $page->refreshPicFromWeb();
        $this->view->page = Pages::findOrNewByPageNumAndIssue($issue->id,['page_num'=>$page_num]);
        $this->view->issue = $issue;
    }

}

