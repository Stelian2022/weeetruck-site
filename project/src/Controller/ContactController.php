<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\DevisType;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact_form")
     */
    public function contactForm(Request $request,MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
       
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the form data
            $formData = $form->getData();
            $recipientEmail = $formData['email'];
            // Send an email
            $email = (new Email())
                ->from($recipientEmail) // Set the recipient email address
                ->to('contact@weeetruck.fr') // Set the recipient email address
                ->subject('Nouvelle soumission de formulaire de contact')
                ->html($this->renderView('/contact/email/contact.html.twig', ['formData' => $formData]));

            $mailer->send($email);
            // Redirigez vers une autre page ou affichez un message de confirmation
            return $this->redirectToRoute('contact_success');
        }
      
        $formDevis = $this->createForm(DevisType::class);
        $formDevis->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
      
            return $this->redirectToRoute('devis_reponse');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'devistype' => $formDevis->createView()
        ]);
    }

    /**
     * @Route("/contact/success", name="contact_success")
     */
    public function contactSuccess(): Response
    {
        return $this->render('contact/success.html.twig');
    }
}
