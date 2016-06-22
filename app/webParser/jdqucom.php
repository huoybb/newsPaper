<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/22
 * Time: 16:01
 */

namespace App\webParser;


use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class jdqucom implements newspaperParserInterface
{

    public function getLatestIssues()
    {
        $url = 'http://www.jdqu.com/bklist-10.html';
        $path = str_replace(basename($url),'',$url);
        $crawler = myCrawler::getCrawler($url);
        $newsPaper = [];
        $crawler->filter('.img-wrap a img')->each(function($row) use(&$newsPaper,$path){
            /** @var Crawler $row */
            $url = $path.$row->parents()->attr('href');
            $title = $row->parents()->attr('title');
            $poster = $row->attr('src');

            if(preg_match('/.+([0-9]{4}-[0-9]{1,2}-[0-9]{1,2})/sm', $title, $regs)){
                $date = $this->formatDate($regs[1]);
                $newsPaper[]=compact('url','title','date','poster');
            }
        });
        return $newsPaper;
    }

    public function getPageInfoForIssue($url)
    {
        $path = str_replace('/'.basename($url),'',$url);

        $crawler = myCrawler::getCrawler($url);
        $pages = [];
        $crawler->filter('.paging')->first()->filter('li')->each(function($row,$i) use(&$pages,$path,$url){
            /** @var Crawler $row */
            if($i == 0 ) return ;
            $page_num = trim($row->text());
            if($i != 1 && $row->filter('a')->count()) $url = $path.$row->filter('a')->attr('href');
            if(preg_match('|^[0-9]{1,2}$|',$page_num)) $pages[] = compact('page_num','url');
        });
        return $pages;
    }

    public function getImageSrc($url)
    {
        $crawler = myCrawler::getCrawler($url);
        if (preg_match('%http_ref\(\'(https?://.+?/mypoco/myphoto/.+jpg)\'\)%sm', $crawler->html(), $regs)) {
            $url = $regs[1];
        }else{
            $url = $crawler->filter('img')->attr('src');
        }
        return $url;
    }



    private function formatDate($dateString)
    {
        return Carbon::createFromTimestamp(strtotime($dateString))->format('Y-m-d');
    }
}