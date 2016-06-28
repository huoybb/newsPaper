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
        $TBD = \Issues::find('status = "TBD"')->count();
        $Total = \Issues::find()->count();
        $output->writeln("Issues need to download : {$TBD}/{$Total}, ".($Total - $TBD)." downloaded!");

        $IMG = \Pages::find('status = "IMG"')->count();
        $URL = \Pages::find('status = "URL"')->count();
        $HTML =\Pages::find('status = "HTML"')->count();
        $output->writeln("Pages :IMG({$IMG}),URL({$URL}),HTML({$HTML}), Total:".($IMG+$URL+$HTML));
    }

}