<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/28
 * Time: 5:36
 */

namespace App\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class getPage extends Command
{
    public function configure()
    {
        $this->setName('newspaper:getPage')
            ->setDescription('Download a page image from web by page_id')
            ->addArgument('page',InputArgument::REQUIRED,'page_id ? ');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $page_id = $input->getArgument('page');
        $page = \Pages::findFirst($page_id);
        $output->writeln('Has found the page and is downloading from '.$page->url.' ...');
        if($page && $page->isNewOrLackingImage()) $page->getInfoAndImageFromWeb(true);
        $output->writeln('Done');
    }
}