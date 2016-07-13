<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/13
 * Time: 17:09
 */

namespace App\policies;


class focusPolicy
{
    public function edit(\Users $user,\Focus $focus)
    {
        if(! $user) return false;

        if($user->id == $focus->user_id) return  true;

//        if($user->isAdministrator()) return true;
        return false;
    }
    public function delete(\Users $user,\Focus $focus)
    {
        if(! $user) return false;

        if($user->id == $focus->user_id) return  true;

//        if($user->isAdministrator()) return true;
        return false;
    }

}