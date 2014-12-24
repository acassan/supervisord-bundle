<?php
namespace SupervisordBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('supervisord:init')
            ->setDescription('Create base config files for run local supervisor')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conf = $this->getContainer()->get('templating')->render('@SupervisordBundle/supervisord.conf.twig', array(

        ));
        file_put_contents($this->getContainer()->getParameter('kernel.root_dir').'/supervisord.conf', $conf);
        mkdir($this->getContainer()->getParameter('kernel.root_dir').'/supervisor');
    }
}
