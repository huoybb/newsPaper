<?php

use App\myPlugins\myTools;

class Pages extends \App\myPlugins\myModel
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
    public $page_num;

    /**
     *
     * @var integer
     */
    public $issue_id;

    /**
     *
     * @var string
     */
    public $src;
    /**
     *
     * @var string
     */
    public $url;

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
     * @param $url
     * @return Pages
     */
    public static function findOrNewByUrl($url)
    {
        $instance = static::query()
            ->where('url = :url:',['url'=>$url])
            ->execute()->getFirst();
        if(! $instance){
            $instance = new static;
            $instance->url = $url;
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
        return 'pages';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pages[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pages
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * @return Issues
     */
    public function getIssue()
    {
        return Issues::findFirst($this->issue_id);
    }

    /**
     * @return \Phalcon\Mvc\ModelInterface | Pages
     */
    public function nextPage()
    {
        return $this->getPageByPageNum($this->getNextPageNum());
    }

    public function prevPage()
    {
        return $this->getPageByPageNum($this->getPrevPageNum());
    }

    public function getPageByPageNum($pageNum)
    {
        return static::query()
            ->where('page_num = :num:',['num'=>$pageNum])
            ->andWhere('issue_id = :issue:',['issue'=>$this->issue_id])
            ->execute()->getFirst();
    }

    
    public function getNextPageNum()
    {
        $num = $this->page_num +1;
        if($num > $this->getIssue()->pages) $num = 1;
        return $num;
    }
    public function getPrevPageNum()
    {
        $num = $this->page_num - 1;
        if($num == 0) $num = $this->getIssue()->pages;
        return $num;
    }

    public function refreshPicFromWeb()
    {
        set_time_limit(0);
        $old = '../'.$this->src;
        if(file_exists($old)) unlink($old);
        $this->src = myTools::downloadImage($this->url);
        $this->save();

    }
    public function beforeDelete()
    {
        $file = $this->src;
        if(getMyEnv() == 'web') $file = preg_replace('|public/|','',$file);
        unlink($file);
    }


}
