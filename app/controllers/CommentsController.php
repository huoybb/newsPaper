<?php

class CommentsController extends \App\myPlugins\myController
{

    public function indexAction($page = 1)
    {
        $builder = ModelsManager::createBuilder()->from(Comments::class)->orderBy('id DESC');
        $page = $this->getPaginatorByQueryBuilder($builder,20,$page);
        $this->view->comments = $page->items;
        $this->view->page = $page;
    }

}
