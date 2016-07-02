<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/2
 * Time: 16:29
 */

namespace App\models;


use App\myPlugins\myModel;

trait CommentableTrait
{
    public function getComments()
    {
        /** @var myModel $this */
        return $this->make('comments',function(){
            /** @var myModel $this */
            return \Comments::query()
                ->where('commentable_type = :type:',['type'=>get_class($this)])
                ->andWhere('commentable_id = :id:',['id'=>$this->id])
                ->orderBy('created_at DESC')
                ->execute();
        });
    }

    public function hasAnyComments()
    {
        return $this->getComments()->count();
    }

}