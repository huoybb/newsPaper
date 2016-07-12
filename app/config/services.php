<?php
/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 *
 * 服务的形式采用如下的形式来自动注入到Di中
 */
$di = new \App\myPlugins\myDI();

$providers = [
    'config'            =>\App\serviceProviders\configProvider::class,
    'url'               =>\App\serviceProviders\urlProvider::class,
    'view'              =>\App\serviceProviders\viewProvider::class,
    'db'                =>\App\serviceProviders\dbProvider::class,
    'modelsMetadata'    =>\App\serviceProviders\modelsMetadataProvider::class,
    'flash'             =>\App\serviceProviders\flashProvider::class,
    'crypt'             =>\App\serviceProviders\cryptProvider::class,
    'session'           =>\App\serviceProviders\sessionProvider::class,
    'security'          =>\App\serviceProviders\securityProvider::class,
    'cookies'           =>\App\serviceProviders\cookiesProvider::class,
    'router'            =>\App\serviceProviders\routerProvider::class,
    'eventsManager'     =>\App\serviceProviders\eventsManagerProvider::class,
    'dispatcher'        =>\App\serviceProviders\dispatcherProvider::class,
    'auth'              =>\App\serviceProviders\authProvider::class,


    //下面是自主加载的服务
    'newspaperparser'   =>\App\serviceProviders\newpaperparserProvider::class,//获取报纸信息的服务；
    'myTools'           =>\App\serviceProviders\myToolsProvider::class,
];

$di->register($providers);