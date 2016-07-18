<?php

class ColumnsController extends \App\myPlugins\myController
{

    public function showAction(Columns $column)
    {
//        dd($column->getPages()->toArray());
        $this->view->column = $column;
    }

    public function showPageAction(Columns $column, Pages $page)
    {
        $page->setCollection($column->getPages());
        $this->view->column = $column;
        $this->view->page = $page;
    }



}

