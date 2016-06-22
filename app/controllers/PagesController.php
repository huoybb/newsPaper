<?php

class PagesController extends \App\myPlugins\myController
{

    public function indexAction()
    {

    }

    public function showAction(Pages $page)
    {
        if(! $page->src) $page->refreshPicFromWeb();
        $this->view->page = $page;
    }

    public function refreshAction(Pages $page)
    {
        $page->refreshPicFromWeb();
        $this->redirectBack();
    }


}

