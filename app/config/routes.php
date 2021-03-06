<?php
use App\middlewares\isLogin;
use App\myPlugins\myRouter;

$router = new myRouter(false);

//$router->bindProvider(FilesInterface::class,Files::class);

$router->removeExtraSlashes(true);

$router->notFound('index::notFound');
$router->group([isLogin::class],function(myRouter $router){
    $router->addx('/','issues::index')->setName('home');
    $router->addx('/statistics','index::index')->setName('home.statistics');

    $router->addGet('/newspapers/{newspaper:[0-9]+}','newspapers::show')->setName('newspapers.show');
    $router->addGet('/newspapers/{newspaper:[0-9]+}/page/{page:[0-9]+}','newspapers::show')->setName('newspapers.show.page');
    $router->addx('/newspapers/{newspaper:[0-9]+}/addIssue','newspapers::addIssue')->setName('newspapers.addIssue');

    $router->addGet('/issues','issues::index')->setName('issues.index');
    $router->addGet('/issues/page/{page:[0-9]+}','issues::index')->setName('issues.index.page');
    $router->addGet('/issues/{issue:[0-9]+}','issues::show')->setName('issues.show');
    $router->addGet('/issues/{issue:[0-9]+}/delete','issues::delete')->setName('issues.delete');
    $router->addGet('/issues/{issue:[0-9]+}/page/{page_num:[0-9A-Za-z]+}','issues::showPage')->setName('issues.showPage');
    $router->addPost('/issues/{issue:[0-9]+}/page/{page_num:[0-9A-Za-z]+}/addPageTitle','issues::addPageTitle')->setName('issues.addPageTitle');

    $router->addGet('/pages/{page:[0-9]+}','pages::show')->setName('pages.show');

    $router->addGet('/newspapers/{newspaper:[0-9]+}/updateFromWeb','newspapers::updateFromWeb')->setName('fromWeb.updateNewspaper');
    $router->addGet('/issues/{issue:[0-9]+}/update','issues::update')->setName('fromWeb.updateIssue');
    $router->addGet('/pages/{page:[0-9]+}/refresh','pages::refresh')->setName('fromWeb.refreshPage');

    $router->addGet('/focus','focus::index')->setName('focus.index');
    $router->addGet('/focus/page/{page:[0-9]+}','focus::index')->setName('focus.index.page');
    $router->addPost('/focus/add','focus::add')->setName('focus.add');
    $router->addGet('/focus/items/{focus:[0-9]+}','focus::show')->setName('focus.show');
    $router->addGet('/focus/items/{focus:[0-9]+}/delete','focus::delete')->setName('focus.delete');
    $router->addx('/focus/items/{focus:[0-9]+}/edit','focus::edit')->setName('focus.edit');
    $router->addPost('/focus/items/{focus:[0-9]+}/addTag','focus::addTag')->setName('focus.addTag');
    $router->addPost('/focus/items/{focus:[0-9]+}/addComment','focus::addComment')->setName('focus.addComment');
    $router->addGet('/focus/items/{focus:[0-9]+}/tags','focus::showTags')->setName('focus.showTags');
    $router->addGet('/focus/items/{focus:[0-9]+}/tags/{tag:[0-9]+}/delete','focus::deleteTag')->setName('focus.deleteTag');

    $router->addGet('/tags','tags::index')->setName('tags.index');
    $router->addGet('/tags/{tag:[0-9]+}','tags::show')->setName('tags.show');
    $router->addGet('/tags/{tag:[0-9]+}/delete','tags::delete')->setName('tags.delete');
    $router->addx('/tags/{tag:[0-9]+}/edit','tags::edit')->setName('tags.edit');
    $router->addPost('/tags/{tag:[0-9]+}/addComment','tags::addComment')->setName('tags.addComment');
    $router->addGet('/tags/{tag:[0-9]+}/focus/{focus:[0-9]+}','tags::showFocus')->setName('tags.showFocus');
    $router->addPost('/tags/{tag:[0-9]+}/focus/{focus:[0-9]+}/addTag','focus::addTag')->setName('tags.showFocus.addTag');
    $router->addPost('/tags/{tag:[0-9]+}/focus/{focus:[0-9]+}/addComment','focus::addComment')->setName('tags.showFocus.addComment');

    $router->addGet('/search/{search:[^/]+}','focus::search')->setName('focus.search');
    $router->addGet('/search/{search:[^/]+}/page/{page:[0-9]+}','focus::search')->setName('focus.search.page');
    $router->addGet('/search/{search:[^/]+}/focus/{focus:[0-9]+}','focus::showSearchItem')->setName('focus.search.showItem');
    $router->addPost('/search/{search:[^/]+}/focus/{focus:[0-9]+}/addComment','focus::addComment')->setName('focus.search.showItem.addComment');
    $router->addPost('/search/{search:[^/]+}/focus/{focus:[0-9]+}/addTag','focus::addTag')->setName('focus.search.showItem.addTag');

    $router->addGet('/comments','comments::index')->setName('comments.index');
    $router->addGet('/comments/{page:[0-9]+}','comments::index')->setName('comments.index.page');
    $router->addGet('/comments/item/{comment:[0-9]+}/delete','comments::delete')->setName('comments.delete');
    $router->addx('/comments/item/{comment:[0-9]+}/edit','comments::edit')->setName('comments.edit');

    $router->addx('/logout','auth::logout')->setName('logout');

    $router->addGet('/columns/{column:[0-9]+}','columns::show')->setName('columns.show');
    $router->addGet('/columns/{column:[0-9]+}/p/{page:[0-9]+}','columns::show')->setName('columns.show.page');
    $router->addGet('/columns/{column:[0-9]+}/page/{page:[0-9]+}','columns::showPage')->setName('columns.showPage');

});


$router->addx('/login','auth::login')->setName('login');


return $router;