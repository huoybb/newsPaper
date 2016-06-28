<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/28
 * Time: 16:44
 */

namespace App\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class showStatistics extends Command
{
    public function configure()
    {
        $this->setName('showStatistics')
            ->setDescription('Show Newspaper Statistics');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $stat = new \Statistics();
        $IssueStat = $stat->getIssueStat();
        $output->writeln("Issues need to download : {$IssueStat['TBD']}/{$IssueStat['Total']}, {$IssueStat['Completed']} have been downloaded!");

        $PageStat = $stat->getPageStat();
        $output->writeln("Pages :IMG({$PageStat['IMG']}),URL({$PageStat['URL']}),HTML({$PageStat['HTML']}), Total: {$PageStat['Total']}, {$PageStat['Completed']} pages have been downloaded!");
    }

}