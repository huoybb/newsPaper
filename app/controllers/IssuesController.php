<?php

class IssuesController extends \App\myPlugins\myController
{

    public function indexAction($page=1)
    {
//        set_time_limit(0);
//        foreach(Newspapers::findFirst(1)->getIssues() as $issue){
//            foreach ($issue->getPages() as $page){
//                $page->setColumn();
//            }
//        }
//        dd('done!');
        $this->view->page = $this->getPaginator(Issues::find(['order'=>'date DESC,id DESC']),15,$page);
    }
    public function showAction(Issues $issue)
    {
//        $issue->delete();
//        set_time_limit(0);
//        $issue->getPagesFromWeb();
//        dd($issue->getFocuses()->toArray());
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
//        dd($issue->getFirstPage());
//        $page = Pages::findOrNewByPageNumAndIssue($issue->id,['page_num'=>$page_num]);
//        dd($page->getNextPageNum());
        $this->view->page = Pages::findOrNewByPageNumAndIssue($issue->id,['page_num'=>$page_num]);

        $this->view->issue = $issue;
    }
    public function addPageTitleAction(Issues $issue,$page_num)
    {
        $newspaper = $issue->getNewsPaper();
        $columnTitle = $this->request->get('colunmTitle');
        $column = Columns::findOrNewByNewspaperAndTitle($newspaper,$columnTitle);

        $page = Pages::findOrNewByPageNumAndIssue($issue->id,['page_num'=>$page_num]);
        $page->save(['column_id'=>$column->id]);
        if($this->request->isAjax()) return 'success';
        return $this->redirectBack();
    }


}

