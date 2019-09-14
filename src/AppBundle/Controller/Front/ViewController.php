<?php

namespace AppBundle\Controller\Front;

use Symfony\{
    Component\Routing\Annotation\Route,
    Bundle\FrameworkBundle\Controller\Controller
};

class ViewController extends Controller
{
    /**
     * @Route("/", name="home", defaults={"page"=1})
     */
    public function indexAction()
    {
        return $this->render("Front/home.html.twig");
    }
}