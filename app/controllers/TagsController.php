<?php

class TagsController extends \App\myPlugins\myController
{

    public function indexAction()
    {
        $this->view->tags = Tags::fatchAllWithCount();
    }

    public function showAction(Tags $tag)
    {
//        dd($tag->getFocus()->toArray());
//        dd($this->router->getMatchedRoute()->getName());
        $this->view->mytag = $tag;
    }
    public function addCommentAction(Tags $tag)
    {
        $data = $this->request->getPost();
        $tag->addComment($data);
        return 'success';
    }
    public function editAction(Tags $tag)
    {
        if($this->request->isPost()){
            $data = $this->request->getPost();
            $tag->save($data);
            return $this->redirectByRoute(['for'=>'tags.show','tag'=>$tag->id]);
        }
        $this->view->mytag = $tag;
        $this->view->form = new \App\forms\tagForm($tag);
    }

    public function showFocusAction(Tags $tag, Focus $focus)
    {
//        dd($focus->getNextFocus($tag)->toArray());
        $this->view->mytag = $tag;
        $this->view->focus = $focus;
    }
    public function deleteAction(Tags $tag)
    {
        $tag->delete();
        return $this->redirectByRoute(['for'=>'tags.index']);
    }

}

