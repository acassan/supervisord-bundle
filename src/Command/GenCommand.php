<?php
namespace SupervisordBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('supervisord:gen')
            ->addArgument('name', InputArgument::REQUIRED, 'Programm name')
            ->addArgument('cmd', InputArgument::IS_ARRAY, 'Symfony command')
            ->addOption('count', null, InputOption::VALUE_OPTIONAL, 'numproc')
            ->setDescription('run supervisor instance')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $supervisor = $this->getContainer()->get('ivan1986_supervisor.supervisor_service');
        $supervisor->genProgrammConf($input->getArgument('name'), array(
            'name' => $input->getArgument('name'),
            'command' => join(' ', $input->getArgument('cmd')),
            'numprocs' => $input->getOption('count')?:null,
        ));
    }
}
