<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/16
 * Time: 16:58
 */

namespace App\Commands;


use App\myPlugins\myTools;
use App\webParser\myCrawler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class Cartoon extends Command
{
    public function configure()
    {
        $this->setName('cartoon')
            ->setDescription('Download cartoon pic');
//            ->addArgument('page',InputArgument::REQUIRED,'page_id ? ');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {

//        $links = $this->getIssues();
//        foreach($links as $link){
//            $output->writeln(iconv('UTF-8','GBK',$link['title']).':'.$link['src']);
//
//        }
//        foreach ($this->getPages() as $num => $page){
//            myTools::downloadImage($page,'public/cartoons');
//        }

    }
    protected function getPages($url=null){
        $url = 'http://www.dmzx.com/manhua/64/6410374.html';
        $crawler = myCrawler::getCrawler($url);
        preg_match_all('/picAy\[([0-9]+)\]="([^"]+)"/sm', $crawler->html(), $result, PREG_PATTERN_ORDER);
        $src = [];
        foreach($result[2] as $key=>$value){
            $src[$key] = 'http://jpgcdn.dmzx.com/img/'.$value;
        }
        return $src;
    }
    protected function getIssues($url = null)
    {
        $url = 'http://www.dmzx.com/manhua/64/';
        $links = [];

        $crawler = myCrawler::getCrawler($url);
        $crawler->filter('.subsrbelist')->first()->filter('a')->each(function($row) use(&$links,$output) {
            /** @var Crawler $row */
            $title = $row->attr('title');
            $src = $row->attr('href');
            if(preg_match('|高清|',$title)) {
                $links[]=compact('title','src');
            }
        });
        return array_reverse($links);
    }

}