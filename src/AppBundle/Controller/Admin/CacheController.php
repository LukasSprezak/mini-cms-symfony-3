<?php

namespace AppBundle\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Bundle\FrameworkBundle\{
    Console\Application,
    Controller\Controller
};
use Symfony\Component\HttpFoundation\{
    RedirectResponse,
    Request,
    Response
};

/**
 * @Route("/admin")
 */
class CacheController extends Controller
{
    /**
     * @Route("/cache/clear", name="cache_clear")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function cacheClearAction(Request $request)
    {
        $input = new ArgvInput ([
            'console',
            'cache:clear'
            ]);
        $application = new Application($this->get('kernel'));
        $application->run($input);

        return $this->render('admin/setting/index.html.twig');
    }
}