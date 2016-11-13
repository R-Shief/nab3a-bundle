<?php

namespace RShief\Nab3aBundle\Console;

use GuzzleHttp\Client;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class AbstractCommand extends Command
{
    use LoggerAwareTrait;
    use ContainerAwareTrait;

    const CHILD_PROC_TIMER = 1e-3;

    /**
     * @var array
     */
    protected $params;

    protected function configure()
    {
        $this->addArgument('stream', InputArgument::REQUIRED, 'stream id');
        parent::configure();
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $client = $this->container->get('nab3a.guzzle.client.params');
        $response = $client->get('stream/'.$input->getArgument('stream'));

        $this->params = [
          'type' => 'filter',
          'parameters' => \GuzzleHttp\json_decode($response->getBody(), true),
        ];
    }
}
