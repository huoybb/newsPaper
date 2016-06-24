<?php

class NewspapersController extends \App\myPlugins\myController
{

    public function indexAction()
    {

    }
    
    public function updateFromWebAction(Newspapers $newspaper)
    {
        FlashFacade::notice('download '. $newspaper->downloadIssuesFromWeb() .' Issues');
        $this->redirectBack();
    }

    public function showAction(Newspapers $newspaper)
    {
        dd($newspaper);
    }

    
}

