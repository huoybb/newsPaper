<?php

class Columns extends \App\myPlugins\myModel
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $title;

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

    /**
     *
     * @var integer
     */
    public $newspaper_id;

    public static function findOrNewByNewspaperAndTitle($newspaper, $columnTitle)
    {
        $instance =  static::query()
            ->where('newspaper_id = :newspaper:',['newspaper'=>$newspaper->id])
            ->andWhere('title = :title:',['title'=>$columnTitle])
            ->execute()->getFirst();
        if(! $instance){
            $instance = new static;
            $instance->save(['newspaper_id'=>$newspaper->id,'title'=>$columnTitle]);
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
        return 'columns';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Columns[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Columns
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
