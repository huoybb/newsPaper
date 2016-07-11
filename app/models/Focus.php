<?php

class Focus extends \App\myPlugins\myModel
{

    use \App\models\taggableTrait;
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
    public $title;

    /**
     *
     * @var string
     */
    public $description;

    /**
     *
     * @var integer
     */
    public $page_id;

    /**
     *
     * @var integer
     */
    public $Y;

    /**
     *
     * @var \Carbon\Carbon
     */
    public $created_at;

    /**
     *
     * @var \Carbon\Carbon
     */
    public $updated_at;

    /**
     * @var null|\Illuminate\Support\Collection
     */
    protected $collection = null;

    public static function search($search)
    {
        $query = static::query();

        $keywords = preg_split('|\s+|',$search);
        foreach($keywords as $key=>$word){
            $query->andWhere('title like :search'.$key.':',['search'.$key=>'%'.$word.'%']);
//                ->orWhere('description like :search'.$key.':',['search'.$key=>'%'.$word.'%']);
        }

        return $query->execute();
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'focus';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Focus[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Focus
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    private $page;
    private $issue;
    private $newspaper;

    public function getNewsPaperName()
    {
        $page = $this->page ? $this->page:$this->page = Pages::findFirst($this->page_id);
        $issue = $this->issue ? $this->issue : $this->issue = $page->getIssue();
        $newspaper = $this->newspaper ? $this->newspaper : $this->newspaper = $issue->getNewsPaper();
        return $newspaper->title.'::'.$issue->present()->date.'::第'.$page->page_num.'版';
    }

    public function getNewsPaperUrl($withScrollTop = true)
    {
        $page = $this->page ? $this->page:$this->page = Pages::findFirst($this->page_id);
        $issue = $this->issue ? $this->issue : $this->issue = $page->getIssue();
        $url = UrlFacade::get(['for'=>'issues.showPage','issue'=>$issue->id,'page_num'=>$page->page_num]);
        if($withScrollTop) $url .= '?Y='.$this->Y;
        return $url;
    }

    public function addTag($tag)
    {
        if(is_string($tag)){
            $tag = Tags::findOrCreateByName(trim($tag));
        }
        if(! is_a($tag,Tags::class)) throw new Exception('Focus::addTag有问题，应该传入Tags对象类型参数');
        Taggables::findOrCreateByObjects($tag,$this);
        return $this;
    }
    public function addMultTags($tagsString)
    {
        $tags = preg_split('|\s+|',trim($tagsString));
        foreach($tags as $tag){
            if(! preg_match('|\s+|',$tag)) $this->addTag($tag);
        }
        return $this;
    }

    public function getNextFocus($tag = null)
    {
        if($this->collection){
            $key = $this->getCurrentKeyFromCollection();
            $next = $key+1 < collect($this->collection)->count() ? $key+1 : 0;
            return $this->collection[$next];
        }
        $instance = $this->getQuery($tag)
            ->andWhere('Focus.id > :id:',['id'=>$this->id])
            ->orderBy('Focus.id ASC')
            ->execute()->getFirst();
        if(!$instance) $instance = $this->getFirstFocus($tag);
        return $instance;
    }
    public function getPrevFocus($tag = null)
    {
        if($this->collection){
            $key = $this->getCurrentKeyFromCollection();
            $prev = $key > 0  ? $key-1 : collect($this->collection)->count()-1;
            return $this->collection[$prev];
        }
        $instance = $this->getQuery($tag)
            ->andWhere('Focus.id < :id:',['id'=>$this->id])
            ->orderBy('Focus.id DESC')
            ->execute()->getFirst();
        if(!$instance) $instance = $this->getLastFocus($tag);
        return $instance;
    }

    public function getFirstFocus($tag = null)
    {
        $query = $this->getQuery($tag);
        return $query->orderBy('Focus.id')->execute()->getFirst();
    }

    public function getLastFocus($tag = null)
    {
        $query = $this->getQuery($tag);
        return $query->orderBy('Focus.id DESC')->execute()->getFirst();
    }
    public function getQuery(Tags $tag = null)
    {
        $query = static::query()
            ->limit(1);
        if(!$tag) return $query;
        return $query
            ->leftJoin('Taggables','taggable_type = "Focus" AND taggable_id = Focus.id')
            ->where('Taggables.tag_id = :tag:',['tag'=>$tag->id]);


    }

    public function setCollection($collection)
    {
        $this->collection = $collection;
    }

    private function getCurrentKeyFromCollection()
    {
        return collect($this->collection)->search(function($item){
            return $this->id == $item['id'];
        });
    }


}
