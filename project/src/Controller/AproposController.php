<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\DevisType;

class AproposController extends AbstractController
{
    #[Route('/apropos', name: 'apropos')]
    public function index(Request $request): Response
    {
         
        $form = $this->createForm(DevisType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
       
            return $this->redirectToRoute('devis_reponse');
        }
        return $this->render('apropos/index.html.twig', [
            'devistype' => $form->createView()
        ]);
    }
}
