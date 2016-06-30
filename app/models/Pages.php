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
     * @var string
     */
    public $status;
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
     * @param $issue_id
     * @param array $page
     * @return Pages
     */
    public static function findOrNewByPageNumAndIssue($issue_id, array $page)
    {
        $instance = static::query()
            ->where('issue_id = :issue:',['issue'=>$issue_id])
            ->andWhere('page_num = :num:',['num'=>$page['page_num']])
            ->execute()->getFirst();
        if(! $instance){
            $instance = new static($page);
            $instance->issue_id = $issue_id;
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
        if($num > $this->getIssue()->present()->pages) $num = 1;
        return $num;
    }
    public function getPrevPageNum()
    {
        $num = $this->page_num - 1;
        if($num == 0) $num = $this->getIssue()->present()->pages;
        if($num == null) $num =1;//@fixed  当没有下载完全的时候，修正一下
        return $num;
    }

    public function refreshPicFromWeb()
    {
        $this->getInfoAndImageFromWeb(true);

    }
    public function beforeDelete()
    {
        $file = $this->src;
        if(getMyEnv() == 'web') $file = preg_replace('|public/|','',$file);
        unlink($file);
    }

    public function getInfoAndImageFromWeb($downloadImage)
    {
        if($this->isImageUrlNeedParsing()){
            $this->url = NewspaperParserFacade::getImageSrc($this->url);
            if(! $this->url) throw new Exception('没有找到图片的下载地址！');
        }

        if($this->hasDownloadedImage()){
            $old = $this->src;
            if(getMyEnv() == 'web') $old = '../'.$this->src;
            if(file_exists($old)) unlink($old);
        }

        if($this->isNewOrLackingImage()){
            if($downloadImage) {
                $this->src = myTools::downloadImage($this->url);
                $this->setStatus();
            }
            $this->save();
        }
    }

    public function isNewOrLackingImage()
    {
        return !$this->id || !$this->src;
    }

    public function isImageUrlNeedParsing()
    {
        return preg_match('|.+html\s*$|',$this->url);
    }
    private function hasDownloadedImage()
    {
        return (bool)$this->src;
    }

    public function hasGotURL()
    {
        return ! $this->isImageUrlNeedParsing();
    }

    public function setStatus()
    {
        if( $this->src ) $this->status = 'IMG';
        if( ! $this->src && $this->hasGotURL() ) $this->status = 'URL';
        if( $this->isImageUrlNeedParsing()) $this->status = 'HTML';
    }




}
