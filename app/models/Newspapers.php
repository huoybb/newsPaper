<?php

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
        $crawler = myCrawler::getCrawler('http://www.hqck.net/');
        $newsPaper = [];
        $crawler->filter('.baozhi-list li')->each(function($row) use(&$newsPaper) {

            /** @var Crawler $row */
            $url = $row->filter('a')->attr('href');
            $title = trim($row->text());
            if(preg_match('/'.$this->title.'.+([0-9]{4}-[0-9]{2}-[0-9]{2})/sm', $title, $regs)){
                $date = $regs[1];
                $newsPaper[]=compact('url','title','date');
            }
        });
        return $newsPaper;
    }

    /**
     * @return Issues[]
     */
    public function getIssues()
    {
        return Issues::query()
            ->where('newspaper_id = :newspaper:',['newspaper'=>$this->id])
            ->orderBy('title DESC')
            ->execute();
    }

    public function downloadIssuesFromWeb()
    {
        set_time_limit(0);
        $issues = $this->getLatestIssuesFromWeb();
        $downloadCount = 0;

        foreach($issues as $row){
            $issue = \Issues::findOrNewByUrl($row['url']);
            if(! $issue->id){ //如果没有下载过这一期，则
                $issue->save(array_merge($row,['newspaper_id'=>$this->id]));
                $issue->getPagesFromWeb();
                $downloadCount += 1;
            }
        }
        return $downloadCount;
    }

}
