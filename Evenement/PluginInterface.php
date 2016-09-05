<?php

namespace RShief\Nab3aBundle\Evenement;

use Evenement\EventEmitterInterface;

interface PluginInterface
{
    /**
     * @param EventEmitterInterface $emitter
     */
    public function attachEvents(EventEmitterInterface $emitter);
}
