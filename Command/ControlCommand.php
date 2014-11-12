<?php

namespace SupervisordBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ControlCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('supervisord:control')
            ->addArgument('cmd', InputArgument::IS_ARRAY, 'supervisorCtl command')
            ->setDescription('execute supervisorCtl command')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $result = $this->getContainer()->get('supervisord')
            ->execute(join(' ', $input->getArgument('cmd')));
        echo $result->getOutput();
    }
}
