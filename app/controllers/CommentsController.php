<?php

class CommentsController extends \App\myPlugins\myController
{

    public function indexAction($page = 1)
    {
        $builder = ModelsManager::createBuilder()
            ->from(Comments::class)
            ->where('user_id = :user:',['user'=>AuthFacade::user()->id])
            ->orderBy('id DESC');
        $page = $this->getPaginatorByQueryBuilder($builder,20,$page);
        $this->view->comments = $page->items;
        $this->view->page = $page;
    }
    public function deleteAction(Comments $comment)
    {
        $comment->delete();
        return $this->redirectBack();
    }

    public function editAction(Comments $comment)
    {
        if($this->request->isGet()){
            $this->session->set('lastUrl',$_SERVER['HTTP_REFERER']);
        }
        if($this->request->isPost()){
            $content = $this->request->get('content');
            $comment->save(compact('content'));
            $url = $this->session->get('lastUrl');
            $this->session->destroy('lastUrl');
            return $this->response->redirect($url);
        }
        $this->view->comment = $comment;
        $this->view->form = new \App\forms\commentForm($comment);
    }



}

