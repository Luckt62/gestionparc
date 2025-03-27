<?php

// src/Controller/VisiteurController.php
namespace App\Controller;

use App\Entity\VisiteurMedical;
use App\Form\VisiteurMedicalType;
use App\Repository\VisiteurMedicalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisiteurController extends AbstractController
{
    /**
     * Afficher la liste des visiteurs (réservé aux gestionnaires).
     * 
     * @Route("/visiteurs", name="app_visiteur_index")
     */
    public function index(VisiteurMedicalRepository $visiteurMedicalRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GESTIONNAIRE');

        $visiteurs = $visiteurMedicalRepository->findAll();
        return $this->render('visiteur/index.html.twig', [
            'visiteurs' => $visiteurs,
        ]);
    }

    /**
     * Ajouter un visiteur (réservé aux gestionnaires).
     * 
     * @Route("/visiteur/ajouter", name="visiteur_add")
     */
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GESTIONNAIRE');

        $visiteur = new VisiteurMedical();
        $form = $this->createForm(VisiteurMedicalType::class, $visiteur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($visiteur);
            $em->flush();

            $this->addFlash('success', 'Le visiteur a été ajouté avec succès.');

            return $this->redirectToRoute('app_visiteur_index');
        }

        return $this->render('visiteur/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Modifier un visiteur (réservé aux gestionnaires).
     * 
     * @Route("/visiteur/{id}/modifier", name="visiteur_edit")
     */
    public function edit(VisiteurMedical $visiteur, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GESTIONNAIRE');

        $form = $this->createForm(VisiteurMedicalType::class, $visiteur);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Le visiteur a été modifié avec succès.');

            return $this->redirectToRoute('app_visiteur_index');
        }

        return $this->render('visiteur/edit.html.twig', [
            'form' => $form->createView(),
            'visiteur' => $visiteur
        ]);
    }

    /**
     * Supprimer un visiteur (réservé aux gestionnaires).
     * 
     * @Route("/visiteur/{id}/supprimer", name="visiteur_delete")
     */
    public function delete(VisiteurMedical $visiteur, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_GESTIONNAIRE');

        $em->remove($visiteur);
        $em->flush();

        $this->addFlash('success', 'Le visiteur a été supprimé avec succès.');

        return $this->redirectToRoute('app_visiteur_index');
    }
}
