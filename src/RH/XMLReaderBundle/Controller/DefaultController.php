<?php

namespace RH\XMLReaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RHXMLReaderBundle:Default:index.html.twig');
    }
}
