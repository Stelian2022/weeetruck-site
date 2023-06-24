<?php

namespace App\Controller\DashbordUsers;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/entreprise/crud')]
class EntrepriseCrudController extends AbstractController
{
    #[Route('/', name: 'index.intreprises', methods: ['GET'])]
    public function index(EntrepriseRepository $entrepriseRepository, Security $security): Response
    {
        $user = $security->getUser();
        if ($user instanceof Entreprise) {
        }
        return $this->render('entreprise_crud/index.html.twig', [
            'entreprises' => $entrepriseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'nouvelle.entreprise', methods: ['GET', 'POST'])]
    public function new(Request $request, EntrepriseRepository $entrepriseRepository): Response
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrepriseRepository->save($entreprise, true);

            return $this->redirectToRoute('app_entreprise_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprise_crud/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'profil.entreprise', methods: ['GET'])]
    public function show(Entreprise $entreprise, Security $security): Response
    {
        $user = $security->getUser();
        if ($user instanceof Entreprise) {
        }
        return $this->render('entreprise_crud/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entreprise_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entreprise $entreprise, EntrepriseRepository $entrepriseRepository): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrepriseRepository->save($entreprise, true);

            return $this->redirectToRoute('entreprise', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprise_crud/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entreprise_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Entreprise $entreprise, EntrepriseRepository $entrepriseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $entreprise->getId(), $request->request->get('_token'))) {
            $entrepriseRepository->remove($entreprise, true);
        }

        return $this->redirectToRoute('app_entreprise_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
