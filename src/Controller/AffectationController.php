<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Form\AffectationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/affectation')]
final class AffectationController extends AbstractController
{
    #[Route('', name: 'app_affectation_index', methods: ['GET'])]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vehiculeId = $request->query->get('vehiculeId');

        if ($vehiculeId) {
            $affectations = $entityManager->getRepository(Affectation::class)
                ->createQueryBuilder('a')
                ->where('a.vehicule = :vehiculeId')
                ->setParameter('vehiculeId', $vehiculeId)
                ->getQuery()
                ->getResult();
        } else {
            $affectations = $entityManager->getRepository(Affectation::class)->findAll();
        }

        return $this->render('affectation/index.html.twig', [
            'affectations' => $affectations,
        ]);
    }

    #[Route('/new', name: 'app_affectation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $affectation = new Affectation();
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($affectation);
            $entityManager->flush();

            return $this->redirectToRoute('app_affectation_index');
        }

        return $this->render('affectation/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_affectation_show', methods: ['GET'])]
    public function show(Affectation $affectation): Response
    {
        return $this->render('affectation/show.html.twig', [
            'affectation' => $affectation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_affectation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Affectation $affectation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_affectation_index');
        }

        return $this->render('affectation/edit.html.twig', [
            'form' => $form->createView(),
            'affectation' => $affectation,
        ]);
    }

    #[Route('/{id}', name: 'app_affectation_delete', methods: ['POST'])]
    public function delete(Request $request, Affectation $affectation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $affectation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($affectation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_affectation_index');
    }
}
