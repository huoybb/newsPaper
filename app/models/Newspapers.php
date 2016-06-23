<?php

use App\myPlugins\myTools;
use App\webParser\myCrawler;
use Symfony\Component\DomCrawler\Crawler;

class Newspapers extends \App\myPlugins\myModel
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
    public $url;
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
     * @param $name
     * @return Newspapers
     */
    public static function findOrNewByName($name)
    {
        $instance = static::query()
            ->where('title = :name:',['name'=>$name])
            ->execute()->getFirst();
        if(!$instance){
            $instance = new static;
            $instance->save(['title'=>$name]);
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
        return 'newspapers';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Newspapers[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Newspapers
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function getLatestIssuesFromWeb()
    {
        $url = $this->url;
        return NewspaperParserFacade::getLatestIssues($url);
//        $result = [];
//        for($i = 1;$i<=18;$i++){
//            $url = "http://www.jdqu.com/bklist-10-{$i}.html";
//            foreach (NewspaperParserFacade::getLatestIssues($url) as $issue){
//                $result[] = $issue;
//            }
//        }
//        return $result;
    }

    /**
     * @return Issues[]
     */
    public function getIssues()
    {
        return Issues::query()
            ->where('newspaper_id = :newspaper:',['newspaper'=>$this->id])
            ->orderBy('date DESC')
            ->execute();
    }

    public function downloadIssuesFromWeb()
    {
        set_time_limit(0);
        $issues = $this->getLatestIssuesFromWeb();
        if(! count($issues)) throw new Exception('没有找到报纸的最近几期的信息');
        $downloadCount = 0;

        foreach($issues as $row){
//            $issue = \Issues::findOrNewByUrl($row['url']);
            $issue = Issues::findOrNewByDateAndNewsPaper($row,$this->id);
            if(! $issue->id){ //如果没有下载过这一期，则
                if($row['poster']) $row['poster'] = myTools::downloadImage($row['poster']);
                $issue->save(array_merge($row,['newspaper_id'=>$this->id]));
                $issue->getPagesFromWeb();
                $downloadCount += 1;
            }
        }
        return $downloadCount;
    }

}
