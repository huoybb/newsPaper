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

    public function addIssueAction(Newspapers $newspaper)
    {
        if($this->request->isPost()){
            $data = $this->request->getPost();
            $my = [];
            $my['date']=\Carbon\Carbon::createFromTimestamp(strtotime($data['Issue_Date']))->toDateString();
            $my['poster']=$data['Issue_Poster_URL'];
            $my['title']=$newspaper->title.' '.$data['Issue_Date'];
            $my['url']=$data['URL'];
            $my['newspaper_id'] = $newspaper->id;
            Issues::saveNew($my);
            return $this->redirectBack();
        }
        $this->view->form = \App\forms\issueForm::buildForm();
        $this->view->newspaper = $newspaper;
    }


}

