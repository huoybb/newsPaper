<?php

class Tags extends \App\myPlugins\myModel
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
    public $name;

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

    public static function findOrCreateByName($tagName)
    {
        $instance = static::query()
            ->where('name = :name:',['name'=>$tagName])
            ->execute()->getFirst();
        if(! $instance){
            $instance = static::saveNew(['name'=>$tagName]);
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
        return 'tags';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tags[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tags
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function getFocus()
    {
        $rowSet = Focus::query()
            ->leftJoin('Taggables','Taggables.taggable_type = "Focus" AND Taggables.taggable_id = Focus.id')
            ->where('Taggables.tag_id = :tag:',['tag'=>$this->id])
            ->columns(['Focus.*','Taggables.*'])
            ->execute();
        $result = [];
        foreach($rowSet as $row){
            $focus = $row->focus;
            $focus->addTagTime = $row->taggables->created_at;
            $result[] = $focus;
        }
        return $result;
    }


}
