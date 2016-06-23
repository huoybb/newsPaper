<?php
namespace App\myPlugins;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Paginator\Adapter\Model;
use Phalcon\Paginator\Adapter\QueryBuilder;

abstract class myController extends Controller
{

    /**根据路由数组来转到相应的地址
     * @param $array
     * @return mixed
     */
    protected  function redirectByRoute($array)
    {
        $url = $this->url->get($array);
        return $this->response->redirect($url);
    }

    protected function redirectBack(){
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }


    /**
     * @param $rowSets
     * @param $limit
     * @param $page
     * @return mixed
     */
    protected function getPaginator($rowSets, $limit, $page)
    {
        $paginator = new Model([
            'data'=>$rowSets,
            'limit'=>$limit,
            'page'=>$page
        ]);
        return $this->cyclingPage($paginator->getPaginate());
    }

    /**
     * @param $builder
     * @param $limit
     * @param $page
     * @return 
     */
    protected function getPaginatorByQueryBuilder($builder, $limit, $page)
    {
        $paginator = new QueryBuilder([
            'builder'=>$builder,
            'limit'=>$limit,
            'page'=>$page
        ]);
        return $this->cyclingPage($paginator->getPaginate());
    }
    private function cyclingPage($page)
    {
        if($page->next == $page->current) $page->next = 1;
        if($page->before == $page->current) $page->before = $page->last;
        return $page;
    }


    protected function success()
    {
        echo 'success';
        return $this->view->disable();
    }

    protected function failed()
    {
        echo 'failed';
        return $this->view->disable();
    }
    
}
