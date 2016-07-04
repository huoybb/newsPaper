<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/20
 * Time: 12:48
 */

namespace App\Commands;


use App\webParser\abbaocn;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewsPaper extends Command
{
    public function configure()
    {
        $this->setName('newspaper:getNewspaper')
            ->setDescription('Download Latest NewsPaper from Web!');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
//        $paper = \Newspapers::findOrNewByName('深圳晶报');
//        $issues = $paper->getLatestIssuesFromWeb();
//        dd($issues);


        $downloadCount = 0;
        foreach (\Newspapers::find() as $paper){
            $downloadCount += $paper->downloadIssuesFromWeb($output);
        }
        $output->writeln('download '.$downloadCount.' Issues');
//        $parser = new abbaocn();
//        $result = $parser->getLatestIssues('http://www.abbao.cn/paper/paper_10.html');
////        $result = $parser->getPageInfoForIssue('http://www.abbao.cn/issue/12730494128');
////        $result = $parser->getImageSrc('http://www.abbao.cn/page/12730515918858');
//        dd($result);
    }
}