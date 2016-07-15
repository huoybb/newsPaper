<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/15
 * Time: 20:12
 */

namespace App\policies;


class issuePolicy
{
    public function deleteAndUpdate(\Users $user, \Issues $issue)
    {
        return $user->notes == 'admin';
    }

}