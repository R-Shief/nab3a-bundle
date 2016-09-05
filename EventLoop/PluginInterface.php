<?php

namespace RShief\Nab3aBundle\EventLoop;

use React\EventLoop\LoopInterface;

interface PluginInterface
{
    public function attach(LoopInterface $loop);
}
