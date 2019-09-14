<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\{
    HttpFoundation\Response,
    Routing\Annotation\Route
};

class PageController extends Controller
{
    /**
     * @Route( "/{alias}", name="pages", defaults={"page"=1})
     * @param Page $page
     * @return Response
     */
    public function pageIndex(Page $page)
    {
        if (null === $page) {
            throw $this->createNotFoundException('Strona nie został znaleziony');
        }

        return $this->render("Front/page.html.twig", ["page" => $page]);
    }
}