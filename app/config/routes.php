<?php
use App\myPlugins\myRouter;

$router = new myRouter(false);

//$router->bindProvider(FilesInterface::class,Files::class);

$router->removeExtraSlashes(true);
//$router->addMiddlewaresForEveryRoute([isLoggedin::class]);

$router->notFound('index::notFound');

$router->add('/','index::index')->setName('home');

$router->add('/newspapers/{newspaper:[0-9]+}','newspapers::show')->setName('newspapers.show');
$router->add('/newspapers/{newspaper:[0-9]+}/page/{page:[0-9]+}','newspapers::show')->setName('newspapers.show.page');
$router->add('/newspapers/{newspaper:[0-9]+}/addIssue','newspapers::addIssue')->setName('newspapers.addIssue');

$router->add('/issues/{issue:[0-9]+}','issues::show')->setName('issues.show');
$router->add('/issues/{issue:[0-9]+}/delete','issues::delete')->setName('issues.delete');
$router->add('/issues/{issue:[0-9]+}/page/{page_num:[0-9]+}','issues::showPage')->setName('issues.showPage');

$router->add('/pages/{page:[0-9]+}','pages::show')->setName('pages.show');

$router->add('/newspapers/{newspaper:[0-9]+}/updateFromWeb','newspapers::updateFromWeb')->setName('fromWeb.updateNewspaper');
$router->add('/issues/{issue:[0-9]+}/update','issues::update')->setName('fromWeb.updateIssue');
$router->add('/pages/{page:[0-9]+}/refresh','pages::refresh')->setName('fromWeb.refreshPage');

$router->addGet('/focus','focus::index')->setName('focus.index');
$router->addPost('/focus/add','focus::add')->setName('focus.add');
$router->addGet('/focus/items/{focus:[0-9]+}','focus::show')->setName('focus.show');

return $router;