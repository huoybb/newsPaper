<?php

class IndexController extends \App\myPlugins\myController
{

    public function indexAction()
    {
        $newsPaper = Newspapers::findOrNewByName('参考消息');
        $Issues = $newsPaper->getIssues();
        $this->view->Issues = $Issues;
    }
    

}

