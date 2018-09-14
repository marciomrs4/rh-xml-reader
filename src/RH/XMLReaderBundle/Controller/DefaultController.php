<?php

namespace RH\XMLReaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class DefaultController extends Controller
{
    /**
     * @Route("/",name="index")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/home",name="home")
     */
    public function homeAction()
    {
        return $this->render('RHXMLReaderBundle:Default:index.html.twig');
    }


}
