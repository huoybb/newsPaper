<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/13
 * Time: 11:16
 */
require 'vendor/autoload.php';
/**
 * Read the configuration
 */
$config = include  "app/config/config.php";

/**
 * Read auto-loader
 */
include  "app/config/loader.php";

/**
 * Read services
 */
include  "app/config/services.php";


function getMyEnv()
{
    return 'cli';
}


$app = new \Symfony\Component\Console\Application('My NewsPaper Command Line Tool','1.0');

$app->add(new \App\Commands\NewsPaper());
$app->add(new \App\Commands\updateIssue());
$app->add(new \App\Commands\getPage());
$app->add(new \App\Commands\showStatistics());
$app->add(new \App\Commands\route());
$app->add(new \App\Commands\Cartoon());

$app->run();