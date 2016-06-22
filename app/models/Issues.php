<?php

use App\myPlugins\myTools;
use App\webParser\myCrawler;
use Symfony\Component\DomCrawler\Crawler;

class Issues extends \App\myPlugins\myModel
{

    /**
     *
     * @var integer
     */
    public $id;    /**
    /**
     *
     * @var string
     */
    public $title;
    /**
     *
     * @var integer
     */
    public $pages;

    /**
     *
     * @var string
     */
    public $url;

    /**
     *
     * @var integer
     */
    public $newspaper_id;

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
     * @param $url
     * @return Issues
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
        return 'issues';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Issues[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Issues
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }



    public function getPagesFromWeb()
    {
        $path = $this->getUrlPath($this->url);

        $crawler = myCrawler::getCrawler($this->url);
        $pages = [];
        $crawler->filter('.paging')->first()->filter('li')->each(function($row,$i) use(&$pages,$path){
            /** @var Crawler $row */
            if($i == 0 || $i == 1) return ;
            $page_num = $row->text();
            $url = $this->url;
            if($i != 2) $url = $path.$row->filter('a')->attr('href');
            if(preg_match('|[0-9]+|',$page_num)) $pages[] = compact('page_num','url');
        });
        foreach($pages as $page){
            $this->getPageImage($page);
        }
        $this->save(['pages'=>count($pages)]);

    }
    public function getPageImage(array $page)
    {
        $url = $page['url'];
        $pager = Pages::findOrNewByUrl($url);
        if(! $pager->src){
            $crawler = myCrawler::getCrawler($url);
            if (preg_match('%http_ref\(\'(https?://.+?/mypoco/myphoto/.+jpg)\'\)%sm', $crawler->html(), $regs)) {
                $url = $regs[1];
            }else{
                $url = $crawler->filter('img')->attr('src');
            }
            if($url){
                $src = myTools::downloadImage($url);
                $page_num = $page['page_num'];
                $issue_id = $this->id;
                $pager->save(compact('page_num','src','url','issue_id'));
            }

        }
        
    }
    private function getUrlPath($url)
    {
        return str_replace(basename($url),'',$url);
    }

    /**
     * @return Pages[]
     */
    public function getPages()
    {
        return Pages::query()
            ->where('issue_id = :issue:',['issue'=>$this->id])
            ->execute();
    }

    /**
     * @return Pages
     */
    public function getFirstPage()
    {
        return Pages::query()
            ->where('issue_id = :issue:',['issue'=>$this->id])
            ->andWhere('page_num = :num:',['num'=>1])
            ->execute()->getFirst();

    }


}
