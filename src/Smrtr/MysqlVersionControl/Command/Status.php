<?php

namespace Smrtr\MysqlVersionControl\Command;

use Smrtr\MysqlVersionControl\Command\Parameters\CommonParametersTrait;
use Smrtr\MysqlVersionControl\Command\Parameters\ComposerParams;
use Smrtr\MysqlVersionControl\Helper\Configuration;
use Smrtr\MysqlVersionControl\Receiver\Status as StatusReceiver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Status is a symfony console command that reports the status of the given environment.
 *
 * @package Smrtr\MysqlVersionControl\Command
 * @author Joe Green <joe.green@smrtr.co.uk>
 */
class Status extends Command
{
    use CommonParametersTrait;

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        // Parameters
        $this
            ->addEnvironmentArgument()
            ->addGlobalOptions()
        ;

        // Name & description
        $this
            ->setName("status")
            ->setDescription('Reports the status of the database for the given environment')
        ;
    }

    /**
     * Pass parameters to the receiver and execute.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $composerParams = new ComposerParams;
        $composerParams->applyComposerParams($this, $input);
        Configuration::applyConsoleConfigurationOptions($input);

        $receiver = new StatusReceiver;
        return $receiver->execute(
            $input,
            $output,
            $input->getArgument('env'),
            $input->getOption('versions-path'),
            $input->getOption('provisional-version')
        );
    }
}
