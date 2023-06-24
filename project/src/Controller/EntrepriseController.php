<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketType;
use App\Entity\Entreprise;
use App\Repository\TicketRepository;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;


class EntrepriseController extends AbstractController
{
    #[Route('/entreprise', name: 'entreprise')]
    public function index(Security $security): Response
    {
        $entreprise = $security->getUser();
        return $this->render('Entreprise/index.html.twig', [
            'entreprise' => $entreprise
        ]);
    }


    #[Route('/Entreprise/Tickets', name: 'indexTicketEntreprise', methods: ['GET'])]
    public function indexTicket(TicketRepository $ticketRepository, Security $security): Response
    {
        // Récupérer l'utilisateur connecté
        $entreprise = $security->getUser();

        // Vérifier si l'utilisateur est connecté
        if (!$entreprise) {
            throw new AccessDeniedException('Utilisateur non connecté.');
        }

        // Récupérer les tickets de l'utilisateur connecté en utilisant l'adresse e-mail
        $tickets = $ticketRepository->findByEmail($entreprise->getEmail());

        return $this->render('Entreprise/Tickets/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }




    #[Route('/Entreprise/Tickets/new', name: 'newTicketEntreprise', methods: ['GET', 'POST'])]
    public function new(Request $request, TicketRepository $ticketRepository): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('imageFilename')->getData();
            if ($imageFile) {
                $newFilename = md5(uniqid()) . '.' . $imageFile->guessExtension();
                // Move the uploaded file to a directory
                $imageFile->move(
                    $this->getParameter('image_directory'), // Define this parameter in your config/services.yaml file
                    $newFilename
                );
                $ticket->setImageFilename($newFilename);
            }

            $ticketRepository->save($ticket, true);



            return $this->redirectToRoute('indexTicketEntreprise', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Entreprise/Tickets/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }
    #[Route('/Entreprise/Tickets/{id}', name: 'showTicketEntreprise', methods: ['GET'])]
    public function show(Ticket $ticket): Response
    {
        return $this->render('Entreprise/Tickets/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }
    #[Route('/Entreprise/Tickets/{id}', name: 'deleteTicketEntreprise', methods: ['POST'])]
    public function delete(Request $request, Ticket $ticket, TicketRepository $ticketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $ticket->getId(), $request->request->get('_token'))) {
            $ticketRepository->remove($ticket, true);
        }

        return $this->redirectToRoute('indexTicketEntreprise', [], Response::HTTP_SEE_OTHER);
    }
}
