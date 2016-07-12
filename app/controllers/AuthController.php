<?php

class AuthController extends \App\myPlugins\myController
{

    public function loginAction()
    {
        if($this->request->isPost()){
            $name = $this->request->get('name');
            $password = $this->request->get('password');
            $user = Users::findFirst(['name = "'.$name.'"']);
            if( $user AND $this->security->checkHash($password,$user->password)){
                AuthFacade::login($user);
                FlashFacade::success("欢迎{$user->name}回来");
                return $this->redirectByRoute(['for'=>'home']);
            }
        }

    }
    public function logoutAction()
    {
        AuthFacade::logout();
        $this->redirectByRoute(['for'=>'home']);
    }

}

