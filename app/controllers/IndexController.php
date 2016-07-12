<?php

class IndexController extends \App\myPlugins\myController
{

    public function indexAction()
    {
        $this->view->newspapers = Newspapers::find();
        $this->view->stat = new Statistics();
    }

    public function notFoundAction()
    {
        dd('没有发现你请求的url');
    }

    

}

