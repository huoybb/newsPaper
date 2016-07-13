<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/30
 * Time: 20:11
 */
use App\myPlugins\myGate;

$gate = new myGate();
$policies = [
    Focus::class => \App\policies\focusPolicy::class,
    Users::class =>\App\policies\userPolicy::class,
//    Comments::class     =>  \policies\commentsPolicy::class,
//    Tags::class         =>  \policies\tagsPolicy::class,


];


$gate->register($policies);

//$gate->define('EditAndDeleteComment',function(Users $user, Comments $comment){
//    return $user->id == $comment->user_id;
//});

return $gate;