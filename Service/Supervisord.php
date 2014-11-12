<?php
namespace SupervisordBundle\Service;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Process\Process;

Class Supervisord
{
    /**
     * @var TwigEngine
     */
    private $templating;

    /**
     * @var string
     */
    private $appDir;

    /**
     * @param TwigEngine $templating
     * @param $appDir
     */
    public function __construct(TwigEngine $templating, $appDir)
    {
        $this->templating   = $templating;
        $this->appDir       = $appDir;
    }

    /**
     * Generate config file
     *
     * @param $fileName string file in app/supervisor dir
     * @param $vars array array(name,command,[directory,numprocs], options => [key => value,...])
     */
    public function genProgrammConf($fileName, $vars)
    {
        $template   = '@Supervisord/programm.conf.twig';
        $filePath   = $this->appDir.'/supervisor/'.$fileName.'.conf';

        // Handle directory
        if(!$vars['directory']) {
            $vars['directory'] = $this->appDir;
        }

        // If file exist delete it
        if(file_exists($filePath)) {
            unlink($filePath);
        }

        // Generate content
        $content = $this->templating->render($template, $vars);

        // Write content
        file_put_contents($filePath, $content);
    }

    /**
     * Process ctl command
     *
     * @param $cmd string supervisorctl command
     * @return Process
     */
    public function execute($cmd)
    {
        $p = new Process("supervisorctl ".$cmd);
        $p->setWorkingDirectory($this->appDir);
        $p->run();
        $p->wait();
        return $p;
    }


    /**
     * Reload and update
     */
    public function reloadAndUpdate()
    {
        $this->execute('reread');
        $this->execute('update');
    }

    /**
     * Run supervisord
     */
    public function run()
    {
        $result = $this->execute('status')->getOutput();
        if (strpos($result, 'sock no such file') || strpos($result, 'refused connection')) {
            $p = new Process('supervisord');
            $p->setWorkingDirectory($this->appDir);
            $p->run();
        }
    }
}