<?php

namespace AppBundle\Controller\Admin;

use Symfony\{
    Bundle\FrameworkBundle\Controller\Controller,
    Component\Routing\Annotation\Route
};

class LocaleController extends Controller
{
    /**
     * @Route("/pl", name="language_polish")
     */
    public function selectPolishAction()
    {
        return $this->selectLanguage('pl');
    }

    /**
     * @Route("/en", name="language_english")
     */
    public function selectEnglishAction()
    {
        return $this->selectLanguage('en');
    }

    private function selectLanguage($locale)
    {
        $this->get('session')->set('_locale', $locale);
        return $this->redirect($this->generateUrl('setting'));
    }
}