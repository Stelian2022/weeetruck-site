<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseRegistrationFormType;
use App\Security\EntrepriseAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class EntrepriseRegistrationController extends AbstractController
{
    #[Route('/registerEntreprise', name: 'register_entreprise')]
    public function registerEntreprise(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, EntrepriseAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Entreprise();
        $form = $this->createForm(EntrepriseRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $form->get('plainPassword')->getData() === $form->get('confirmPassword')->getData()
            ) {
                $user->setRoles(['ROLE_ENTREPRISE']);
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

            return $this->render('registration/registerEntreprise/registerEntreprise.html.twig', [
                'entrepriseForm' => $form->createView(),
                'passError' => "Les mots de passe ne sont pas indentiques",
            ]);
        }
    }
        return $this->render('registration/registerEntreprise/registerEntreprise.html.twig', [
            'entrepriseForm' => $form->createView(),
        ]);
    }
   
}
