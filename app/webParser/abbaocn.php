<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/3
 * Time: 18:24
 */

namespace App\webParser;


use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class abbaocn implements newspaperParserInterface
{


    /**
     * @param $url
     * @return mixed  $issues[]=compact('url','title','date','poster');
     */
    public function getLatestIssues($url)
    {
        $crawler = myCrawler::getCrawler($url);
        $issues = [];
        $selectors = [
            '.bzjs-pic',//最新一期的位置
            '.dy-pic ul li',//其余第一页面的位置
        ];
        foreach($selectors as $selector){
            $crawler->filter($selector)->each(function($row) use (&$issues){
                /** @var Crawler $row */
                if($row->filter('.scpic a img')->count()){
                    $url = 'http://www.abbao.cn' . $row->filter('.scpic a')->attr('href');
                    $poster = $row->filter('.scpic a img')->attr('_lazysrc');
                    $title = $this->getCleanText($row->filter('div.ctext > div.p_txt')->text());
                    $date = $this->getDateFromTitle($title);
                    $issues[]= compact('url','poster','title','date');
                }
            });
        }
        return $issues;
    }

    /**
     * @param $url
     * @return mixed  $pages[] = compact('page_num','url');
     */
    public function getPageInfoForIssue($url)
    {
        $urlArray = $this->getPageURLArray($url);
        $pages = [];
        foreach($urlArray as $url){
            $newPages = $this->getPagesInfoFrom($url);
            foreach($newPages as $page){
                $pages[] = $page;
            }
        }
        return $pages;
    }

    /**
     * @param $url
     * @return string $img_src
     */
    public function getImageSrc($url)
    {
        $crawler = myCrawler::getCrawler($url);
        $src = $crawler->filter('img.page_image')->attr('src');
        return $src;
    }

    private function getCleanText($text)
    {
        $text = trim(preg_replace('|\s+|',' ',$text));
        return $text;
//        if(getMyEnv() == 'web') return $text;
//        return iconv('UTF-8','GBK',$text);
    }

    private function getDateFromTitle($title)
    {
        if (preg_match('/.+\s([0-9]{1,2}-[0-9]{1,2}).+/sm', $title, $regs)) {
            $shortDate = Carbon::now()->year.'-'.$regs[1];
            $date = Carbon::createFromTimestamp(strtotime($shortDate))->toDateString();
            return $date;
        }
        if(preg_match('/.+今日.+/',$title)){
            $date = Carbon::now()->toDateString();
            return $date;
        }
        throw new \Exception('Could not parse date info from Parser');
    }

    private function getPagesInfoFrom($url)
    {
        $crawler = myCrawler::getCrawler($url);
        $crawler->filter('div.dytext > a')->each(function ($row) use(&$pages) {
            /** @var Crawler $row */
            $page_num = $this->getPage_num($row->text());
            $url = 'http://www.abbao.cn' . $row->attr('href');
            $pages[] = compact('page_num','url');
        });
        return $pages;
    }

    private function getPageURLArray($url)
    {
        $result=[$url];
        $crawler = myCrawler::getCrawler($url);
        $info = $this->getCleanText($crawler->filter('.font10')->text());
        if (preg_match('/共([1-9])页.+/sm', $info, $regs)) {
            $total = $regs[1];
            if($total > 1){
                for($key = 2;$key <= $total;$key++){
                    $result[] = $url . '/'.$key;
                }
            }
        }

        return $result;
    }
    private function getPage_num($text)
    {
        if (preg_match('/([A-Z0-9]+).*/sm', $text, $regs)) {
            $result = $regs[1];
            return $result;
        }
        throw new \Exception('could not page_num');
    }
}