<?php

class ColumnsController extends \App\myPlugins\myController
{

    public function showAction(Columns $column)
    {
//        dd($column->getPages()->toArray());
        $this->view->column = $column;
    }


}

