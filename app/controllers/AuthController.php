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
                $remember = (bool) $this->request->get('remember',null,false);
                AuthFacade::login($user,$remember);
                FlashFacade::success("欢迎{$user->name}回来");
                return $this->redirectByRoute(['for'=>'home']);
            }
        }
        $this->view->form = new \App\forms\loginForm();

    }
    public function logoutAction()
    {
        AuthFacade::logout();
        $this->redirectByRoute(['for'=>'home']);
    }

}

