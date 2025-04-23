<?php
namespace App\Controller;

use App\Entity\Entretien;
use App\Form\EntretienType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
            $pieceJointe = $form->get('piece_jointe')->getData();

            if ($pieceJointe) {
                $originalFilename = pathinfo($pieceJointe->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $pieceJointe->guessExtension();

                try {
                    $pieceJointe->move(
                        $this->getParameter('entretien_directory'),
                        $newFilename
                    );
                    $entretien->setPieceJointe($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload de la pièce jointe.');
                    return $this->redirectToRoute('app_entretien_new');
                }
            }

            $entityManager->persist($entretien);
            $entityManager->flush();

            $this->addFlash('success', 'L\'entretien a bien été créé.');
            return $this->redirectToRoute('app_entretien_index');
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
            $pieceJointe = $form->get('piece_jointe')->getData();

            if ($pieceJointe) {
                
                $oldFilename = $entretien->getPieceJointe();
                if ($oldFilename) {
                    $oldFilePath = $this->getParameter('entretien_directory') . '/' . $oldFilename;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $originalFilename = pathinfo($pieceJointe->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $pieceJointe->guessExtension();
                try {
                    $pieceJointe->move(
                        $this->getParameter('entretien_directory'),
                        $newFilename
                    );
                    $entretien->setPieceJointe($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'upload de la pièce jointe.');
                }
            }

            $entityManager->flush();

            $this->addFlash('success', 'L\'entretien a bien été mis à jour.');
            return $this->redirectToRoute('app_entretien_index');
        }

        return $this->render('entretien/edit.html.twig', [
            'entretien' => $entretien,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_entretien_delete', methods: ['POST'])]
    public function delete(Request $request, Entretien $entretien, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $entretien->getId(), $request->request->get('_token'))) {
            $file = $entretien->getPieceJointe();
            if ($file) {
                $filePath = $this->getParameter('entretien_directory') . '/' . $file;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $entityManager->remove($entretien);
            $entityManager->flush();

            $this->addFlash('success', 'Entretien supprimé avec succès.');
        }

        return $this->redirectToRoute('app_entretien_index');
    }
}
