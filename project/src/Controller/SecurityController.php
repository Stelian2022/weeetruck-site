<?php

namespace App\Controller;

use App\Form\LoginFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/loginUser', name: 'login_user')]
    public function loginUser(AuthenticationUtils $authenticationUtils, Request $request): Response
    {



        if ($this->getUser()) {
           
            if (in_array('[ROLE_EMPLOYE]', $this->getUser()->getRoles(), true)) {
                // Redirect the user to the profile page
                return $this->redirectToRoute('employe');
            } else {
                // Redirect the user to a different page for other roles if needed
                return $this->redirectToRoute('register_user');
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/loginUser/loginUser.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Request $request): Response
    { // Clear session data
        $request->getSession()->invalidate(); {
            return $this->redirectToRoute('login_user');
        }
    }
}
