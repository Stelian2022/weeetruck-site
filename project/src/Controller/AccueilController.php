<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use DateTime;
use DateTimeImmutable;
use App\Form\DevisType;
use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;




class AccueilController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/accueil', name: 'accueil')]
    public function index(Request $request, CommentsRepository $commentsRepository): Response
    {

        $form = $this->createForm(DevisType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid() && $request->request->has('devistype')) {

            return $this->redirectToRoute('devis_reponse');
        }

        //Commentaires
        //je créé le commentaire
        $comment = new Comments;

        //le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);

        //Traitement de formulaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $createdAt = new \DateTimeImmutable();
            $comment->setCreatedAt($createdAt);
            $comment->setActive(true);

            //je recoupere le contenu de champ parentid(replies)
            $parentid = $commentForm->get("parentid")->getData();


            //je vais chercher le commentaire correspondant

            $em = $this->doctrine->getManager();

            $parent = $em->getRepository(Comments::class)->find($parentid);

            //je definie le parent
            $comment->setParent($parent);
            $em->persist($comment);
            $em->flush();
            // $this -> addFlash('message', 'Votre commentaire a bien été envoyé');
            return $this->redirectToRoute('accueil');
        }
        return $this->render('accueil/index.html.twig', [
            'commentForm' => $commentForm->createView(),
            'devistype' => $form->createView(),
            'comments' => $commentsRepository->findAll()
        ]);
    }
}
