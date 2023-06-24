<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Form\DevisType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DevisController extends AbstractController
{
    #[Route('/Devis/devis', name: 'app_devis')]
    public function index(Request $request): Response
    {
        // $devis = new Devis();
        $form = $this->createForm(DevisType::class);
        $form->handleRequest($request);
        $devisCost = rand(20, 500);
        if ($form->isSubmitted() && $form->isValid()) {
           
            return $this->render('/Devis/devis.html.twig',[
                'devistype' => $form->createView(),
                'cout' => $devisCost
            ]);
        }
       
        return $this->render('/Devis/devis.html.twig',[
            'devistype' => $form->createView(),
            'cout' => $devisCost
        ]);
    }
    // #[Route('/', name: 'base')]
    // public function indexBase(Request $request): Response
    // {
       
   
    //     $form = $this->createForm(DevisType::class);
    //     $form->handleRequest($request);
        
    //     return $this->render('base.html.twig',[
    //         'devistype' => $form->createView(),
    //     ]);
    // }


    // #[Route('/Devis/devis', name: 'devis_reponse')]
    // public function devis(Request $request): Response
    // {
    //     $devis = new Devis();
    //     $form = $this->createForm(DevisType::class);
    //     $form->handleRequest($request);
        
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $devisCost = rand(20, 500);
    //         return $this->redirectToRoute('devis_reponse');
          
    //     }
      
    //     return $this->render('Devis/devis.html.twig',[
    //      'devistype' => $form->createView(),
      
    //            ]);
    // }
}