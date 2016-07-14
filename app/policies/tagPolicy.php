<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/14
 * Time: 20:13
 */

namespace App\policies;


class tagPolicy
{
    public function editAndDelete(\Users $user, \Tags $tag)
    {
        return $user->notes == 'admin';
    }

    public function addComment(\Users $user, \Tags $tag)
    {
        return (bool) $user;
    }

}