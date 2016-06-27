<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/20
 * Time: 12:48
 */

namespace App\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class NewsPaper extends Command
{
    public function configure()
    {
        $this->setName('getNewspaper')
            ->setDescription('Download CanKaoXiaoXi NewsPaper!');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $downloadCount = 0;
        foreach (\Newspapers::find() as $paper){
            $downloadCount += $paper->downloadIssuesFromWeb($output);
        }
        $output->writeln('download '.$downloadCount.' Issues');
    }
}