<?php

namespace AppBundle\Controller\Admin\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\{
    Entity\User,
    Form\User\UserType
};
use Symfony\Component\{
    HttpFoundation\Request,
    Routing\Annotation\Route,
    HttpFoundation\Response,
    Security\Core\Encoder\UserPasswordEncoderInterface
};

class RegisterController extends Controller
{
    /**
     * @Route("/admin/user/register", name="user_register")
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param Request $request
     * @return Response
     */
    public function registerAction(UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $passwordEncoder->encodePassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->redirect('admin');
        }
        return $this->render('admin/security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}