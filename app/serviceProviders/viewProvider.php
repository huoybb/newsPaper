<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/6
 * Time: 12:10
 */

namespace App\serviceProviders;


use App\myPlugins\myProvider;
use Phalcon\Mvc\View;
use RequestFacade;
use SessionFacade;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
class viewProvider extends myProvider
{

    public function register($name)
    {
        $viewProvider = $this;
        $this->di->setShared($name, function () use($viewProvider){

            $config = \ConfigFacade::getService();
            $view = new View();
            // Disable several levels，取消三级的模板渲染机制，这个将来也是可以利用一下的。
            $view->disableLevel(array(
                View::LEVEL_LAYOUT      => true,
                View::LEVEL_MAIN_LAYOUT => true
            ));

            $view->setViewsDir($config->application->viewsDir);

            $view->registerEngines(array(
                '.volt' => function ($view, $di) use ($config,$viewProvider) {

                    return $viewProvider->getVolt($view,$di,$config);
                },
                '.phtml' => 'Phalcon\Mvc\View\Engine\Php'
            ));

            $view->errors = SessionFacade::get('lastErrors',null,true);//设置错误信息变量
            $view->search = RequestFacade::get('search');//设置每个页面的search变量，这个应该是一个全局的变量

            return $view;
        });
    }
    public function getVolt($view,$di,$config)
    {

        $volt = new VoltEngine($view, $di);
        $volt->setOptions([
            'compiledPath' => $config->application->cacheDir,
            'compiledSeparator' => '_',
            'compileAlways'=> true,//修改view的时候用这个
        ]);
        $compiler = $volt->getCompiler();
        $compiler->addFunction('get_class','get_class');
        $compiler->addFunction('isset','isset');
        $compiler->addFilter('basename','basename');
        $compiler->addFilter('formatSizeUnits',function($size){ return 'myTools::formatSizeUnits('.$size.')';});
        $compiler->addFilter('camelize',function($strings){ return 'myTools::camelize('.$strings.')';});
        $compiler->addFilter('date',function($time){ return 'myTools::formatDate('.$time.')';});
        $compiler->addFilter('cut',function($resolvedArgs,$exprArgs){ return 'myTools::cut('.$resolvedArgs.')';});//$exprArgs,这个变量的作用是什么呢？奇怪！
        return $volt;
    }

}