<?php
namespace App\Controller;

use App\Entity\Entretien;
use App\Form\EntretienType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/entretien')]
final class EntretienController extends AbstractController
{
    #[Route(name: 'app_entretien_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $entretiens = $entityManager
            ->getRepository(Entretien::class)
            ->findAll();

        return $this->render('entretien/index.html.twig', [
            'entretiens' => $entretiens,
        ]);
    }

    #[Route('/new', name: 'app_entretien_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entretien = new Entretien();
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion du fichier pièce jointe
            $pieceJointe = $form->get('piece_jointe')->getData();
    
            if ($pieceJointe) {
                $originalFilename = pathinfo($pieceJointe->getClientOriginalName(), PATHINFO_FILENAME);
                // Crée un nom unique pour éviter les conflits
                $newFilename = $originalFilename.'-'.uniqid().'.'.$pieceJointe->guessExtension();
    
                // Déplace le fichier dans le répertoire des uploads
                try {
                    $pieceJointe->move(
                        $this->getParameter('entretien_directory'), // Le répertoire des fichiers définis dans config/services.yaml
                        $newFilename
                    );
    
                    // Sauvegarde le nom du fichier dans l'entité Entretien
                    $entretien->setPieceJointe($newFilename);
                } catch (FileException $e) {
                    // Gérer l'exception si une erreur survient pendant l'upload
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload de la pièce jointe.');
                    return $this->redirectToRoute('app_entretien_new');
                }
            }
    
            // Enregistre l'entité avec la pièce jointe
            $entityManager->persist($entretien);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('entretien/new.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/{id}', name: 'app_entretien_show', methods: ['GET'])]
    public function show(Entretien $entretien): Response
    {
        return $this->render('entretien/show.html.twig', [
            'entretien' => $entretien,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entretien_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entretien $entretien, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretien/edit.html.twig', [
            'entretien' => $entretien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entretien_delete', methods: ['POST'])]
    public function delete(Request $request, Entretien $entretien, EntityManagerInterface $entityManager): Response
    {
        
        if ($this->isCsrfTokenValid('delete' . $entretien->getId(), $request->request->get('_token'))) {
            $entityManager->remove($entretien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entretien_index', [], Response::HTTP_SEE_OTHER);
    }
}
