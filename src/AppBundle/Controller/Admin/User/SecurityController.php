<?php

namespace AppBundle\Controller\Admin\User;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\{
    HttpFoundation\Request,
    HttpFoundation\Response,
    Routing\Annotation\Route,
    Security\Csrf\CsrfTokenManagerInterface,
    Security\Http\Authentication\AuthenticationUtils};

class SecurityController extends Controller
{
    private $tokenManager;
    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * @Route("/login", name="security_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */

    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $csrfToken = $this->tokenManager
            ? $this->tokenManager->getToken('authenticate')->getValue()
            : null;

        return $this->render('admin/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'csrf_token' => $csrfToken
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     * @param Request $request
     */
    public function logoutAction(Request $request): void
    {
    }

    /**
     * @Route("/admin/user/list", name="security_list")
     * @return Response
     */
    public function listAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(User::class)
            ->findAll();

        return $this->render('admin/security/list.html.twig', [
            'users' => $users
        ]);
    }
}