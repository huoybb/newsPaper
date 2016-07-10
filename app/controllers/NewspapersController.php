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
            $data = $this->getRequestIssueData($this->request->getPost(),$newspaper);
            Issues::saveNew($data);
            return $this->redirectBack();
        }
        $this->view->form = new \App\forms\issueForm(new Issues());
        $this->view->newspaper = $newspaper;
    }

    private function getRequestIssueData(array $data, Newspapers $newspaper)
    {
        $data['date']=\Carbon\Carbon::createFromTimestamp(strtotime($data['date']))->toDateString();
        $data['title']=$newspaper->title.' '.$data['date'];
        $data['newspaper_id'] = $newspaper->id;
        return $data;
    }


}

