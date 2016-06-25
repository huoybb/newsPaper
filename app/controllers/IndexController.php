<?php

class IndexController extends \App\myPlugins\myController
{

    public function indexAction()
    {

        $this->view->newspapers = Newspapers::find();
    }
    

}

