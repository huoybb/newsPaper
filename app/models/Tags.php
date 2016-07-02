<?php

class Tags extends \App\myPlugins\myModel
{
    use \App\models\CommentableTrait;
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

    public static function fatchAllWithCount()
    {
        $query = static::query()
            ->leftJoin('Taggables','Taggables.tag_id = Tags.id')
            ->groupBy('Tags.id')
            ->columns(['Tags.id as id','Tags.name AS name','count(Taggables.id) AS count'])
            ->orderBy('count DESC');

        return $query->execute();
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
        return $this->make('focus',function(){
            $rowSet = Focus::query()
                ->leftJoin('Taggables','Taggables.taggable_type = "Focus" AND Taggables.taggable_id = Focus.id')
                ->where('Taggables.tag_id = :tag:',['tag'=>$this->id])
                ->columns(['Focus.*','Taggables.*'])
                ->orderBy('Taggables.created_at DESC')
                ->execute();
            $result = [];
            foreach($rowSet as $row){
                $focus = $row->focus;
                $focus->addTagTime = $row->taggables->created_at;
                $result[] = $focus;
            }
            return $result;
        });
    }

    /**
     * @return \Phalcon\Mvc\Model\Resultset
     */
    public function getTaggables()
    {
        return Taggables::query()
            ->where('tag_id = :id:',['id'=>$this->id])
            ->execute();
    }

    public function delete()
    {
        $taggables = $this->getTaggables();
        if($taggables) $taggables->delete();
        return parent::delete();
    }

    public function deleteTaggable(\App\myPlugins\myModel $focus)
    {
        $taggable = Taggables::query()
            ->where('tag_id = :tag:',['tag'=>$this->id])
            ->andWhere('taggable_type = :type:',['type'=>get_class($focus)])
            ->andWhere('taggable_id = :id:',['id'=>$focus->id])
            ->execute();
//        @todo 是否需要仅仅删除当前用户的Taggable？
        $taggable->delete();
        if($this->getTaggables()->count() == 0) $this->delete();
    }


}
