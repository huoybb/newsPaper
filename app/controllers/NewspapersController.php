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

    public function showAction(Newspapers $newspaper,$page = 1)
    {
//        foreach (Issues::find() as $n){
//            if(! preg_match('|^public|',$n->poster)) $n->save(['poster'=>\App\myPlugins\myTools::downloadImage($n->poster)]);
//        }

        $page = $this->getPaginator($newspaper->getIssues(),15,$page);
        $this->view->page = $page;
        $this->view->newspaper = $newspaper;
    }

}

