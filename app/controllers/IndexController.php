<?php

class IndexController extends \App\myPlugins\myController
{

    public function indexAction($page = 1)
    {
        $newsPaper = Newspapers::findOrNewByName('参考消息');
        
        $page = $this->getPaginator($newsPaper->getIssues(),50,$page);
        $this->view->Issues = $page->items;
    }
    

}

