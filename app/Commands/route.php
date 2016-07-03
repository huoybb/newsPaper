<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/29
 * Time: 21:54
 */

namespace App\Commands;


use App\myPlugins\myRouter;
use Phalcon\Di;
use RouterFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class route extends Command
{
    public function configure()
    {
        $this->setName('route:list')
            ->setDescription('show routes definition')
            ->addArgument('filter',InputArgument::OPTIONAL,'filter by name',null)
            ->addOption('order',null,InputOption::VALUE_OPTIONAL,'Order By field_name',null);
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filter = $input->getArgument('filter');
        $order = $input->getOption('order');
        list($header,$content) = RouterFacade::getTableData($filter,$order);
        $table = new Table($output);
        $table->setHeaders($header)
            ->setRows($content)
            ->render();
    }
}