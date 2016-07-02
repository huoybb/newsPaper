<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/2
 * Time: 9:32
 */

namespace App\models;


use App\myPlugins\myModel;

trait taggableTrait
{
    /**
     * @return \Phalcon\Mvc\Model\Resultset
     */
    public function getTags()
    {
        /** @var myModel $this */
        return $this->make('tags',function(){
            return \Tags::query()
                ->leftJoin('Taggables','Tags.id = Taggables.tag_id')
                ->where('taggable_type = :type:',['type'=>get_class($this)])
                ->andWhere('taggable_id = :id:',['id'=>$this->id])
                ->execute();
        });
    }
    public function hasTags()
    {
        return $this->getTags()->count();
    }


}