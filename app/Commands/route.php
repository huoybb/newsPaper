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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class route extends Command
{
    public function configure()
    {
        $this->setName('route:list')
            ->setDescription('show routes definition');
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        list($header,$content) = RouterFacade::getTableData();
        $table = new Table($output);
        $table->setHeaders($header)
            ->setRows($content)
            ->render();
    }
}