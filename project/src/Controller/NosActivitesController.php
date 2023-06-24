<?php

namespace App\Controller;

use App\Form\DevisType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NosActivitesController extends AbstractController
{
    #[Route('/nos/activites', name: 'nos_activites')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(DevisType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $devisCost = rand(20, 500);
            return $this->redirectToRoute('devis_reponse');
        }
        return $this->render('nos_activites/index.html.twig', [
            'devistype' => $form->createView()
        ]);
    }
}
