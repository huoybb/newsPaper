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
     * @var string
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
     * 报纸栏目的id
     * @var integer
     */
    public $column_id;

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
     * 翻页循环的collection
     * @var \Illuminate\Support\Collection
     */
    protected $collection = null;
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
        if($this->collection){
            $id = $this->id;
            $num = $this->collection->search(function($item) use($id){
                return $id == $item['id'];
            });
            $key = $num+1 <  $this->collection->count() ? $num+1 : 0;
            return (object)$this->collection[$key];
        }

        return $this->getPageByPageNum($this->getNextPageNum());
    }

    public function prevPage()
    {
        if($this->collection){
            $id = $this->id;
            $num = $this->collection->search(function($item) use($id){
                return $id == $item['id'];
            });
            $key = $num-1 >= 0 ? $num-1 : $this->collection->count() - 1;
            return (object)$this->collection[$key];
        }
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


        $collection = collect($this->getIssue()->getPages());
        $page_num = $this->page_num;
        $num = $collection->search(function($item) use($page_num) {
            return $page_num == $item['page_num'];
        });
        $key = $num+1 <  $collection->count() ? $num+1 : 0;
        return $collection[$key]['page_num'];

//        $num = $this->page_num + 1;
//        if($num > $this->getIssue()->present()->pages) $num = 1;
//        return $num;
    }
    public function getPrevPageNum()
    {

        $collection = collect($this->getIssue()->getPages());
        $page_num = $this->page_num;
        $num = $collection->search(function($item) use($page_num) {
            return $page_num == $item['page_num'];
        });
        $key = $num-1 >= 0 ? $num-1 : $collection->count() - 1;
        return $collection[$key]['page_num'];


//        $num = $this->page_num - 1;
//        if($num == 0) $num = $this->getIssue()->present()->pages;
//        if($num == null) $num =1;//@fixed  当没有下载完全的时候，修正一下
//        return $num;
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
                $this->setStatus();//这里怎么能够将几种状态显示出来呢？还是需要进一步的调整
            }
        }

        $this->setColumn();

        $this->save();
    }

    public function isNewOrLackingImage()
    {
        return !$this->id || !$this->src;
    }

    public function isImageUrlNeedParsing()
    {
        return ! preg_match('%.+(gif)|(png)|(jpe?g)\s*$%i',$this->url);
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

    public function getFocuses()
    {
        return Focus::query()->where('page_id = :id:',['id'=>$this->id])->execute();
    }

    public function hasColumn()
    {
        return (bool) $this->column_id;
    }
    public function getColumn()
    {
        return $this->make('column',function (){
            return Columns::findFirst($this->column_id);
        });
    }

    /**
     *设置翻页的collection，
     */
    public function setCollection($collection)
    {
        $this->collection  = collect($collection);
    }

    public function setColumn()
    {
        if($this->getIssue()->getNewsPaper()->title == '参考消息'){
            $this->column_id = Columns::findByDateAndPageNum($this->getIssue()->newspaper_id,$this->getIssue()->date,$this->page_num)->id;
            $this->save();
        }
    }


}
