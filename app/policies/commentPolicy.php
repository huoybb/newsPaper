<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/14
 * Time: 20:07
 */

namespace App\policies;


class commentPolicy
{
    public function editAndDelete(\Users $user, \Comments $comment)
    {
        return $user->id == $comment->user_id;
    }

}