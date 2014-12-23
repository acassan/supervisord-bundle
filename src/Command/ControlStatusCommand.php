<?php
namespace SupervisordBundle\Command;

use SupervisordBundle\Service\Supervisord;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ControlStatusCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('supervisord:ctl:status')
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
        /** @var Supervisord $supervisorManager */
        $supervisordManager = $this->getContainer()->get('supervisord');
        $result             = $supervisordManager->execute('status');

        echo $result->getOutput();
    }
}
