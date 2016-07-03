<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/24
 * Time: 3:17
 */

namespace App\Commands;


use App\myPlugins\myTools;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class updateIssue extends Command
{
    public function configure()
    {
        $this->setName('newspaper:getIssue')
            ->setDescription('update Issue by issue_id')
            ->addArgument('issue',InputArgument::REQUIRED,'issue ID?');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $issue_id = (int) $input->getArgument('issue');
        $issue = \Issues::findFirst($issue_id);
        if($issue->isPosterNeedDownlaod()) {
            $issue->downloadPosterFromWeb();
        }
        $issue->getPagesFromWeb($output,true);
        $output->writeln('done!');
    }
}