<?php

class Taggables extends \App\myPlugins\myModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $tag_id;

    /**
     *
     * @var string
     */
    public $taggable_type;

    /**
     *
     * @var integer
     */
    public $taggable_id;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    public static function findOrCreateByObjects(Tags $tag,Focus $focus)
    {
        $instance = static::query()
            ->where('tag_id = :tag:',['tag'=>$tag->id])
            ->andWhere('taggable_type = :type:',['type'=>get_class($focus)])
            ->andWhere('taggable_id = :id:',['id'=>$focus->id])
            ->execute()->getFirst();
        if(! $instance){
            $instance = static::saveNew([
                'tag_id'        =>$tag->id,
                'taggable_type' =>get_class($focus),
                'taggable_id'   =>$focus->id
            ]);
        }
        return $instance;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'taggables';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Taggables[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Taggables
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
