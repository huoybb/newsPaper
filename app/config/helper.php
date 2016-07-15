<?php

//function faker(){
//    $faker = \Faker\Factory::create();
//    return $faker;
//}

function configDir($file){
    return APP_PATH . "/app/config/".$file;
}

function redirect($url)
{
    if(is_array($url) && isset($url['for'])) $url = UrlFacade::get($url);
    return ResponseFacade::redirect($url,true);
}
