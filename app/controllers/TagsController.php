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
        $this->view->mytag = $tag;
    }
    public function addCommentAction(Tags $tag)
    {
        $data = $this->request->getPost();
        $tag->addComment($data);
        return 'success';
    }

    public function showFocusAction(Tags $tag, Focus $focus)
    {
        $this->view->mytag = $tag;
        $this->view->focus = $focus;
    }
    public function deleteAction(Tags $tag)
    {
        $tag->delete();
        return $this->redirectByRoute(['for'=>'tags.index']);
    }

}

