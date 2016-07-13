<?php
namespace App\myPlugins;
use AuthFacade;
use InvalidArgumentException;

class myGate
{
    protected $abilities;
    protected $policies;

    public function define($ability,$callback)
    {
        if(is_callable($callback)){
            $this->abilities[$ability]=$callback;
        }elseif(is_string($callback) && str_contains($callback,'::')){
            $this->abilities[$ability] = $this->buildAbilityCallback($callback);
        }else{
            throw new InvalidArgumentException("Callback must be a callback or a 'Class::method' string");
        }
        return $this;
    }
    public function allows($ability,$argument)
    {
        return $this->check($ability,[$argument]);
    }

    public function denies($ability, $argument)
    {
        return ! $this->allows($ability, $argument);
    }
    public function check($ability,$arguments = [])
    {
        if(! $user = AuthFacade::user()){
            return false;
        }
        $arguments = is_array($arguments) ? $arguments : [$arguments];

        $callback = $this->resolveAuthCallback($user,$ability,$arguments);

        return call_user_func_array($callback,array_merge([$user],$arguments));
    }

    public function policy($resourse,$policy)
    {
        $this->policies[$resourse] = $policy;
        return $this;
    }

    private function buildAbilityCallback($callback)
    {
        return function () use ($callback) {
            list($class,$method) = explode('::',$callback);
            return call_user_func_array([new $class,$method],func_get_args());
        };
    }

    private function resolveAuthCallback($user, $ability, $arguments)
    {
        if($this->firstArgumentCorrespondsToPolicy($arguments)){
            return $this->resolvePolicyCallback($user,$ability,$arguments);
        }

        if (isset($this->abilities[$ability])){
            return $this->abilities[$ability];
        }

        return function(){ return false;};
    }

    private function firstArgumentCorrespondsToPolicy($arguments)
    {
        return isset($arguments[0]) && is_object($arguments[0]) &&
        isset($this->policies[get_class($arguments[0])]);
    }

    private function resolvePolicyCallback($user, $ability, $arguments)
    {
        return function() use($user,$ability,$arguments) {
            $instance = new $this->policies[get_class($arguments[0])];
            return call_user_func_array(
                [$instance,$ability], array_merge([$user],$arguments)
            );
        };
    }

    public function register($policies)
    {
        foreach($policies as $key=>$policy){
            $this->policy($key,$policy);
        }
        return $this;
    }


}