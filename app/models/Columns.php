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

    public static function findByDateAndPageNum($newspaper_id,$date, $page_num)
    {
        if($newspaper_id == 1){//如果是参考消息
            $columns = [
                'workDay'=>[
                    1=>'头版',2=>'新闻热点',3=>'时事纵横',4=>'经济广角',5=>'财经透视',6=>'军事瞭望',7=>'科技前沿',8=>'社会扫描',9=>'文体看台',10=>'参考论坛',11=>'特别报道',12=>'副刊天地',13=>'海峡两岸',14=>'海外视角',15=>'观察中国',16=>'中国大地'
                ],
                'restDay'=>[ 1=>'头版',2=>'新闻热点',3=>'时事纵横',4=>'经济广角',5=>'军事瞭望',6=>'社会扫描',7=>'科技前沿',8=>'中国大地'
                ]
            ];
            $dayOfWeek = \Carbon\Carbon::createFromTimestamp(strtotime($date))->dayOfWeek;
            if(($dayOfWeek == 0 || $dayOfWeek == 6) && $page_num <= 8) $columnName = $columns['restDay'][$page_num];
            if($page_num <= 16 && !($dayOfWeek == 0 || $dayOfWeek == 6)) $columnName = $columns['workDay'][$page_num];
            if(isset($columnName)) return static::query()
                ->where('title = :title:',['title'=>$columnName])
                ->andWhere('newspaper_id = :newspaper:',['newspaper'=>$newspaper_id])
                ->execute()->getFirst();
        }
        return null;
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

    public function getNewsPaper()
    {
        return $this->make('newspaper',function(){
            return Newspapers::findFirst($this->newspaper_id);
        });
    }

    /**
     * @return Pages
     */
    public function getPages()
    {
        return $this->make('pages',function (){
            return Pages::query()
                ->leftJoin('Issues','Issues.id = Pages.issue_id')
                ->where('column_id = :column:',['column'=>$this->id])
                ->orderBy('Issues.date DESC')
                ->execute();
        });
    }

    public function getPagesQuery()
    {
        return ModelsManager::createBuilder()
            ->from('Pages')
            ->leftJoin('Issues','Issues.id = Pages.issue_id')
            ->where('column_id = :column:',['column'=>$this->id])
            ->orderBy('Issues.date DESC');
    }


}
