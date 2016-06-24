<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/24
 * Time: 3:17
 */

namespace App\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class updateIssue extends Command
{
    public function configure()
    {
        $this->setName('updateIssue')
            ->setDescription('update Issue by date')
            ->addArgument('issue',InputArgument::REQUIRED,'issue ID?');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $issue_id = (int) $input->getArgument('issue');
        $issue = \Issues::findFirst($issue_id);
        $issue->getPagesFromWeb($output);
        $output->writeln('done!');
    }


}