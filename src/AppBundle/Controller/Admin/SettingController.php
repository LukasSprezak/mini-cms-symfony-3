<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\{
    HttpFoundation\Response,
    Routing\Annotation\Route
};

/**
 * @Route("/admin")
 */
class SettingController extends Controller
{
    /**
     * @Route("/setting", name="setting")
     * @return Response
     */
    public function settingAction()
    {
        return $this->render('admin/setting/index.html.twig');
    }
}