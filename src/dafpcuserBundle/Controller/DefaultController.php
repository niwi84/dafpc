<?php

namespace dafpcuserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('dafpcuserBundle:Default:index.html.twig');
    }
}
