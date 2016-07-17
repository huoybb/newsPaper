<?php
namespace App\myPlugins;
use Phalcon\Di\InjectionAwareInterface;
use Users;

class myAuth implements InjectionAwareInterface
{
    /**
     * @var myDI
     */
    protected $di;
    /**
     * @var \Phalcon\Session\Adapter\Files
     */
    protected $session;
    /**
     * @var \Phalcon\Http\Response\Cookies
     */
    protected $cookies;

    protected $user = null;

    /**
     * myAuth constructor.
     * @param $di
     */
    public function init()
    {
        $this->session = $this->di->get('session');
        $this->cookies = $this->di->get('cookies');
        if($this->session->has('auth')){
            $this->loginByUserId($this->session->get('auth'));
        }else{
            if($this->cookies->has('auth')){
                $this->loginByUserId($this->cookies->get('auth')->getValue(),true);
                \FlashFacade::notice('欢迎'.$this->user()->name.'回来');
            }
        }
        return $this;
    }

    public function login(Users $user,$rememberMe = false)
    {
        $this->user = $user;
        $this->registerSession($user,$rememberMe);
        return $this;
    }
    public function isLogin()
    {
        return $this->user <> null;
    }

    public function logout()
    {
        $this->user = null;
        $this->distroySession();
        return $this;
    }
    public function user()
    {
        return $this->user;
    }

    private function registerSession(Users $user,$remember_me=false)
    {
        $this->session->set('auth',$user->id);
        if($remember_me) $this->cookies->set('auth',$user->id,time() + 15 * 86400);
    }

    public function loginByUserId($user_id,$remember_me = false)
    {
        $user = Users::findFirst($user_id);
        if($user) {
            $this->user = $user;
            $this->registerSession($user,$remember_me);
        }
        return $this;
    }

    private function distroySession()
    {
        if($this->cookies->has('auth')) $this->cookies->get('auth')->delete();
        if($this->session->has('auth')) $this->session->remove('auth');
    }

    /**
     * Sets the dependency injector
     *
     * @param mixed $dependencyInjector
     */
    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        $this->di = $dependencyInjector;
        return $this;
    }

    /**
     * Returns the internal dependency injector
     *
     * @return \Phalcon\DiInterface
     */
    public function getDI()
    {
        return $this->di;
    }
}