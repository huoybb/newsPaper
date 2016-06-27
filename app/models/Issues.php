<?php

use App\myPlugins\myTools;
use App\webParser\myCrawler;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class Issues extends \App\myPlugins\myModel
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
    public $date;
    /**
     *
     * @var string
     */
    public $poster;
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
     * @param array $row
     * @param $newspaperId
     * @return Issues
     */
    public static function findOrNewByDateAndNewsPaper(array $row, $newspaperId)
    {
        $instance = static::query()
            ->where('date = :date:',['date'=>$row['date']])
            ->andWhere('newspaper_id = :newspaper:',['newspaper'=>$newspaperId])
            ->execute()->getFirst();
        if(! $instance){
            $instance = new static($row);
            $instance->newspaper_id = $newspaperId;
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

    public function updateFromWeb()
    {
        $this->getPagesFromWeb(null,true);
        $this->getPagesFromWeb(null,true);
    }

    public function getPagesFromWeb(OutputInterface $output = null,$downloadImage = false)
    {
        $pages = NewspaperParserFacade::getPageInfoForIssue($this->url);
        if(! count($pages)) throw new Exception('没有找到报纸的页面信息');
        foreach($pages as $page){
            if($output) $output->write($page['page_num'].' ');
            $p = Pages::findOrNewByPageNumAndIssue($this->id,$page);
            if($p->isNewOrLackingImage()) $p->getInfoAndImageFromWeb($downloadImage);
        }
        if($output) $output->writeln('');
        $this->save(['pages'=>count($pages)]);
    }

    /**
     * @return Pages[]
     */
    public function getPages()
    {
        return Pages::query()
            ->where('issue_id = :issue:',['issue'=>$this->id])
            ->orderBy('page_num')
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
    public function beforeDelete()
    {
        $pages = $this->getPages();
        foreach($pages as $page){
            $page->delete();
        }
    }

    public function getNewsPaper()
    {
        return Newspapers::findFirst($this->newspaper_id);
    }

    public function downloadPosterFromWeb()
    {
//        $url = NewspaperParserFacade::getImageSrc($this->url);
        $this->poster = myTools::downloadImage($this->poster);
        return $this->save();
    }

    public function downloadInfoAndImages($output,$downloadImages = false)
    {
        if($this->IsPosterImageLacking()) $this->downloadPosterFromWeb();
        return $this->getPagesFromWeb($output,$downloadImages);
    }

    public function isNewOrLackingInfo()
    {
        return ! $this->id || ! $this->pages;
    }

    private function IsPosterImageLacking()
    {
        return $this->poster && !preg_match('|^public|',$this->poster);
    }


}
