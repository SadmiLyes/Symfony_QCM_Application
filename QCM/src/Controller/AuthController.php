<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/auth")
 */
class AuthController extends Controller
{
    /**
     * @Route("/login", name="auth_login")
     */
    public function login(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('home');
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('auth/login.html.twig', array(
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/signup", name="auth_signup")
     */
    public function signup(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setRoles(["ROLE_".$user->getRole()]);
            $user->setSalt("");
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('auth/signup.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
