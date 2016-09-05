<?php

namespace RShief\Nab3aBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RShiefNab3aBundle:Default:index.html.twig');
    }
}
