<?php
namespace App\myPlugins;
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/4/11
 * Time: 21:10
 */
abstract class myPresenter
{
    protected $entity;

    /**通用的presenter模式
     * http://mylara.zhaobing/tags/presenter
     * myPresenter constructor.
     * @param $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        if(method_exists($this,$property)){
            return $this->{$property}();
        }

        if(property_exists($this->entity,$property)) {
            return $this->entity->$property;
        }
    }
}