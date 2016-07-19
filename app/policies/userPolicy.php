<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/13
 * Time: 17:26
 */

namespace App\policies;

/**
 * 登录后的用户，享有以下权利，主要是增加的功能，其他的则会考虑是否为拥有者
 * Class userPolicy
 * @package App\policies
 */
class userPolicy
{
    public function addFocus($auth,\Users $user)
    {
        $routeName = \RouterFacade::getMatchedRoute()->getName();
        return $user && ( $routeName == 'issues.showPage' || $routeName == 'columns.showPage');
    }

    public function setColumnName($auth,\Users $user)
    {
        $routeName = \RouterFacade::getMatchedRoute()->getName();
        return $user && ( $routeName == 'issues.showPage');
    }

    public function addTag($auth,\Users $user)
    {
        return $user;
    }
    public function addComment($auth,\Users $user)
    {
        return $user;
    }

}