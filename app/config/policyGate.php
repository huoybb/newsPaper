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
    Focus::class        =>  \App\policies\focusPolicy::class,
    Users::class        =>  \App\policies\userPolicy::class,
    Comments::class     =>  \App\policies\commentPolicy::class,
    Tags::class         =>  \App\policies\tagPolicy::class,
    Issues::class       =>  \App\policies\issuePolicy::class,
];

$gate->register($policies);

//$gate->define('EditAndDeleteComment',function(Users $user, Comments $comment){
//    return $user->id == $comment->user_id;
//});

return $gate;