<?php
use App\myPlugins\myRouter;

$router = new myRouter(false);

//$router->bindProvider(FilesInterface::class,Files::class);

$router->removeExtraSlashes(true);
//$router->addMiddlewaresForEveryRoute([isLoggedin::class]);

$router->notFound('index::notFound');

$router->add('/','index::index')->setName('home');
$router->add('/page/{page:[0-9]+}','index::index')->setName('home.page');

$router->add('/newspapers/{newspaper:[0-9]+}/updateFromWeb','newspapers::updateFromWeb')->setName('updateFromWeb');

$router->add('/issues/{issue:[0-9]+}','issues::show')->setName('issues.show');
$router->add('/issues/{issue:[0-9]+}/delete','issues::delete')->setName('issues.delete');
$router->add('/issues/{issue:[0-9]+}/update','issues::update')->setName('issues.update');

$router->add('/pages/{page:[0-9]+}','pages::show')->setName('pages.show');
$router->add('/pages/{page:[0-9]+}/refresh','pages::refresh')->setName('pages.refresh');
return $router;