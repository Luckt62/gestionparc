<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BaseController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'BaseController',
        ]);
    }
    /**
     * @Route("/gestionnaire", name="gestionnaire_home")
     */
    public function gestionnaireHome(): Response
    {
        if (!$this->isGranted('ROLE_GESTIONNAIRE')) {
            return $this->redirectToRoute('home');
        }

        return $this->render('base/gestionnaire_home.html.twig');
    }
}
