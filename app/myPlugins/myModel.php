<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/7/16
 * Time: 13:44
 */
namespace App\myPlugins;
use Carbon\Carbon;
use Closure;
use Phalcon\Mvc\Model;
use ReflectionClass;

abstract class myModel extends Model{

    
    /*
     * 仿照Laravel对时间的数据进行处理，便于将来的使用
     */
    public $created_at = null;
    public function beforeSave()
    {
        if($this->created_at != null) {
            if(is_a($this->created_at,Carbon::class)) $this->created_at = $this->created_at->toDateTimeString();
        }else{
            $this->created_at = Carbon::now()->toDateTimeString();
        }

        //考虑人为更新这个时间戳的时候，这个时间戳应该是字符串，否则就新生成一个新的时间戳
        if(is_a($this->updated_at,Carbon::class) OR null == $this->updated_at) $this->updated_at = Carbon::now()->toDateTimeString();
        $this->getEventMethodsAndExecute('|beforeSave.+|');
        return true;
    }

    public function afterFetch()
    {
        if(isset($this->created_at)) $this->created_at = Carbon::parse($this->created_at);
        if(isset($this->updated_at)) $this->updated_at = Carbon::parse($this->updated_at);
        $this->getEventMethodsAndExecute('|afterFetch.+|');
    }
    public function afterSave()
    {
        $this->getEventMethodsAndExecute('|afterSave.+|');
    }
    public function beforeDelete()
    {
        $this->getEventMethodsAndExecute('|beforeDelete.+|');
    }



    public function getClassName()
    {
        return get_class($this);
    }


    protected $instance = [];
    //增加临时缓存，避免重复查询，例如在files下索取comments、tags、revs等需要增加一个缓存来减少数据库的查询次数
    public function make($object,Closure $closure)
    {
        if(!isset($this->instance[$object])){
            $this->instance[$object] = $closure();
        }
        return $this->instance[$object];
    }

    //增加缓存功能，利用redis来做缓存，对于大的数据可以采用这个来也许更加方便,需要注意，这里用的压缩算法是igbinary，不是很常见的
    
    static public function saveNew($data){
        $instance = new static();
        $instance->save($data);
        return $instance;
    }

    private function getEventMethodsAndExecute($format){
        $hooks = [];
        foreach($this->getMethods() as $method){
            if(preg_match($format,$method->name)) $hooks[]=$method->name;
        }
        foreach($hooks as $method){
            $this->{$method}();
        }
    }
    private function getMethods(){
        $r = new ReflectionClass($this);
        return $r->getMethods();
    }

    public function present()
    {
        $className = '\\App\\presenters\\'.strtolower(get_class($this)).'Presenter';
        return new $className($this);
    }

} 