<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/22
 * Time: 15:03
 */

namespace App\webParser;


use Symfony\Component\DomCrawler\Crawler;

class hqcknet implements newspaperParserInterface
{
    public function getLatestIssues($url)
    {
        $url ='http://www.hqck.net/';
        $crawler = myCrawler::getCrawler($url);
        $newsPaper = [];
        $crawler->filter('.baozhi-list li')->each(function($row) use(&$newsPaper) {

            /** @var Crawler $row */
            $url = $row->filter('a')->attr('href');
            $title = trim($row->text());
            if(preg_match('/参考消息.+([0-9]{4}-[0-9]{2}-[0-9]{2})/sm', $title, $regs)){
                $date = $regs[1];
                $newsPaper[]=compact('url','title','date');
            }
        });
        return $newsPaper;
    }

    public function getPageInfoForIssue($url)
    {
        $path = str_replace(basename($url),'',$url);

        $crawler = myCrawler::getCrawler($url);
        $pages = [];
        $crawler->filter('.paging')->first()->filter('li')->each(function($row,$i) use(&$pages,$path,$url){
            /** @var Crawler $row */
            if($i == 0 || $i == 1) return ;
            $page_num = $row->text();
            if($i != 2) $url = $path.$row->filter('a')->attr('href');
            if(preg_match('|[0-9]+|',$page_num)) $pages[] = compact('page_num','url');
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
}