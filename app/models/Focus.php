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
        if(! is_a($tag,Tags::class)) $tag = Tags::findOrCreateByName($tag);
        Taggables::findOrCreateByObjects($tag,$this);
        return $this;
    }
    public function addMultTags($tagsString)
    {
        $tags = preg_split('|\s+|',$tagsString);
        foreach($tags as $tag){
            if(! preg_match('|\s+|',$tag)) $this->addTag($tag);
        }
        return $this;
    }

    public function addComment($data)
    {
        $data = array_merge($data,[
            'user_id'=>1,//@todo 将来替换成auth的id
            'commentable_type'=>get_class($this),
            'commentable_id'=>$this->id,
        ]);
        Comments::saveNew($data);
        return $this;
    }


}
