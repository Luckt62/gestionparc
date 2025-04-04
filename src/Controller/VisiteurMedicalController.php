<?php
namespace App\Controller;

use App\Entity\VisiteurMedical;
use App\Form\VisiteurMedicalType;
use App\Repository\VisiteurMedicalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class VisiteurMedicalController extends AbstractController
{
    #[Route('/visiteurs', name: 'visiteur_index', methods: ['GET'])]
    public function index(VisiteurMedicalRepository $visiteurRepository, Request $request): Response
    {
        $searchTerm = $request->query->get('search', '');
        $visiteurs = $visiteurRepository->searchVisiteurs($searchTerm);

        return $this->render('visiteur_medical/index.html.twig', [
            'visiteurs' => $visiteurs,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/visiteur_medical/new', name: 'visiteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GESTIONNAIRE');

        $visiteur = new VisiteurMedical();
        $form = $this->createForm(VisiteurMedicalType::class, $visiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($visiteur);
            $entityManager->flush();

            return $this->redirectToRoute('visiteur_index');
        }

        return $this->render('visiteur_medical/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/visiteur_medical/{id}/edit', name: 'visiteur_edit', methods: ['GET', 'POST'])]
    public function edit(VisiteurMedical $visiteur, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GESTIONNAIRE');

        $form = $this->createForm(VisiteurMedicalType::class, $visiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('visiteur_index');
        }

        return $this->render('visiteur_medical/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/visiteur_medical/{id}/delete', name: 'visiteur_delete', methods: ['POST'])]
    public function delete(VisiteurMedical $visiteur, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GESTIONNAIRE');

        $entityManager->remove($visiteur);
        $entityManager->flush();

        return $this->redirectToRoute('visiteur_index');
    }
}
