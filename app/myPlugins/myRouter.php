<?php
namespace App\myPlugins;

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;
use ReflectionMethod;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/3/21
 * Time: 9:30
 * 核心功能如下：
 * 1、中间件的实现
 * 2、模型绑定，model binding的实现，可以在action函数中指定绑定的类型，类似laravel 5.2 提供的一样
 * 3、模型绑定基础上，实现接口绑定
 */

class myRouter extends Router{
    /**
     * @var array
     */
    public $middlewares = [];

    public $middlewaresForEveryRoute = [];

    public $serviceProvider = [];

    /**
     * myRouter constructor.
     */
    public function __construct($defaultRoutes = false)
    {
        parent::__construct($defaultRoutes);
        if(getMyEnv() == 'web'){
            //        ---------解决中文url不稳定的问题----------
            $this->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);//这种形式对比$_GET('_url')的要稳定，这个函数没有urldecode()，需要手动执行
            $_SERVER['REQUEST_URI'] = urldecode($_SERVER['REQUEST_URI']);
            //       ---------解决中文url不稳定的问题----------
        }

    }

    public function addMiddlewaresForEveryRoute(array $middleware=[])
    {
        $this->middlewaresForEveryRoute = $middleware;
    }

    /**
     * 主要是增加了一个中间件的功能，利用short syntax来增加中间件，这样的好处是路由、中间件在一起，便于管理
     * @param $pattern
     * @param string $path
     * @param array $middleware
     * @return \Phalcon\Mvc\Router\Route
     */
    public function addx($pattern,$path,array $middleware=[],$httpMethods = null)//给路由添加中间件
    {
        $route = $this->add($pattern,$path,$httpMethods);
        $this->middlewares[$route->getRouteId()]=$middleware;
        return $route;
    }


    /**中间件过滤检查：
     * 1、识别出适用所有路由的中间件，
     * 2、允许设置排除的几个典型路由的检查，特别是针对所有路由都适用的中间件，对login等几个路由应该可以排除
     * 3、针对当前路由，识别有哪些中间件适用；
     * 4、如果没有通过中间件的检查，则根据中间件提供的redirectUrl进行路由跳转
     * @param Request $request
     * @param Response $response
     * @return bool
     */
    public function executeMiddleWareChecking(Request $request, Response $response, Dispatcher $dispatcher)
    {
        $route = $this->getMatchedRoute();
        if(null == $route) die('url地址无效，找不到对应的路由设置！');


        //对每个路由都进行验证的中间件！
        foreach($this->middlewaresForEveryRoute as $validator){
            $data = null;
            if(preg_match('|.*:.*|',$validator)) {//此处设置了可以带中间件参数
                list($validator,$data) = explode(':',$validator);
                $data = $dispatcher->getParam($data);
            }

            /** @var myValidation $validator */
            $validator = new $validator;

            if(!in_array($route->getName(),$validator->excludedRoutes) and !$validator->isValid($data)){
                $url = $validator->getRedirectedUrl();
//                    dd($url);
                $response->redirect($url,true);
                return false;
            }
        }

        if($this->hasMatchedMiddleWares($route->getRouteId())){
            $middleWares = $this->getMiddleWares($route->getRouteId());
            foreach($middleWares as $validator){
                if($request->isPost()) $data = $request->getPost();
//                dd($validator);
                if(preg_match('|[^:]+:[^:]+|',$validator)){
                    list($validator,$data) = explode(':',$validator);
                    $data = $dispatcher->getParam($data);
                }

                if(preg_match('|.*Rules$|',$validator)){
                    if(!$request->isPost()) continue;//避免出现get下的错误
                    $rules = new $validator();
                    $validator = (new myValidation())->take($rules);
                }else{
                    $validator = new $validator();
                }

                if(!$validator->isValid($data)){
                    $url = $validator->getRedirectedUrl();
//                    dd($url);
                    $response->redirect($url,true);
                    return false;
                }
            }
        }
        return true;
    }

    /**将router中参数，按照controller的中Action的类型参数进行绑定
     * @param Dispatcher $dispatcher
     */
    public function executeModelBinding(Dispatcher $dispatcher)
    {
        $reflection = new ReflectionMethod($dispatcher->getControllerClass(), $dispatcher->getActiveMethod());
        $actionParams = [];
        foreach($reflection->getParameters() as $parameter){

            $objectId = $dispatcher->getParam($parameter->name);
            if(null == $objectId && $parameter->isDefaultValueAvailable()) $objectId = $parameter->getDefaultValue();

            if($parameter->getClass()){
                $className = $this->getProvider($parameter->getClass()->name);

                if($objectId){
                    if(is_subclass_of($className,\Phalcon\Mvc\Model::class)){
                        /** @var \Phalcon\Mvc\Model $className */
                        $actionParams[$parameter->name] = $className::findFirst($objectId);
                    }else{
                        $actionParams[$parameter->name] = new $className($objectId);
                    }

                }else{
                    $actionParams[$parameter->name] = new $className;
                }
            }else{
                $actionParams[$parameter->name] = $objectId;
            }
        }

        if(count($actionParams)){
            $dispatcher->setParams($actionParams);
        }
    }


// ----------   提供接口绑定, 从interface 到class的绑定----------

    /**
     * @param $key
     * @param $provider
     */
    public function bindProvider($key, $provider)
    {
        $this->serviceProvider[$key]=$provider;
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getProvider($key)
    {
        if(isset($this->serviceProvider[$key])) return $this->serviceProvider[$key];
        return $key;
    }
//--------------helper functions for Middleware-----------------------------------------

    /**判断是否存在对应的中间件
     * @param $route_id
     * @return bool
     */
    private function hasMatchedMiddleWares($route_id)
    {
        return isset($this->middlewares[$route_id]);
    }

    /**获得指定的中间件字符串
     * @param $route_id
     * @return array
     *
     *
     */
    private function getMiddleWares($route_id)
    {
        if(isset($this->middlewares[$route_id])) return $this->middlewares[$route_id];
        return null;
    }

    /**
     * @return array
     */
    public function getTableData()
    {
        $header = ['pattern','path','middleware','httpMethods','name'];
        $content = [];
        foreach($this->getRoutes() as $route){
            /** @var Router\Route $route */
            $name = $route->getName();
            $pattern = $route->getPattern();
            $path = $this->getPathString($route->getPaths());
            $httpMethods = $this->getHttpMethodsString($route->getHttpMethods());
            $middleWares = $this->getMiddleWaresString($route);
            $content[]=[$pattern,$path,$middleWares,$httpMethods,$name];
        }
        return [$header,$content];
    }

    private function getPathString(array $path)
    {
        return $path['controller'].'::'.$path['action'];
    }

    private function getHttpMethodsString($getHttpMethods)
    {
        if(is_array($getHttpMethods)) return '['.implode(',',$getHttpMethods).']';
        if(!$getHttpMethods) return null;
        return '['.$getHttpMethods.']';
    }

    private function getMiddleWaresString(Router\Route $route)
    {
        if(is_array($this->getMiddleWares($route->getRouteId()))) return '['.implode(',',$this->getMiddleWares($route->getRouteId())).']';
        return null;
    }

} 