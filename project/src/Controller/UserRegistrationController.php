<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use App\Security\UtilisateurAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use App\Form\DevisType;

class UserRegistrationController extends AbstractController
{
    #[Route('/registerUser', name: 'register_user')]
    public function registerUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UtilisateurAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationFormType::class, $user);
        $formDevis = $this->createForm(DevisType::class);
        $formDevis->handleRequest($request);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()
            ) {
                $user->setRoles(['ROLE_EMPLOYE']);
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email

                return $userAuthenticator->authenticateUser(
                    $user,
                    $authenticator,
                    $request
                );
            }
         else {
            return $this->render('registration/registerUser/registerUser.html.twig', [
                'userForm' => $form->createView(),
                'passError' => "Les mots de passe ne sont pas indentiques",
            ]);
        }
    }

        return $this->render('registration/registerUser/registerUser.html.twig', [
            'userForm' => $form->createView(),
            'devistype'=>$formDevis->createView()
        ]);
    }
    
}
