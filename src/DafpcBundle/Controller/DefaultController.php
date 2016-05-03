<?php

namespace DafpcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DafpcBundle:Default:index.html.twig');
    }
}
