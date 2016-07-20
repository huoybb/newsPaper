<?php

class ColumnsController extends \App\myPlugins\myController
{

    public function showAction(Columns $column,$page =1)
    {
//        dd($column->getPages()->toArray());
        $this->view->column = $column;
        $this->view->page = $this->getPaginatorByQueryBuilder($column->getPagesQuery(),10,$page);
    }

    public function showPageAction(Columns $column, Pages $page)
    {
        $page->setCollection($column->getPages());
        $this->view->column = $column;
        $this->view->page = $page;
    }



}

