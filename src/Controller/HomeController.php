<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/notre-engagement", name="notreEngagement")
     */
    public function notreEngagement(): Response
    {
        return $this->render('home/notreEngagement.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/les-projets", name="lesProjets")
     */
    public function lesProjets(): Response
    {
        return $this->render('home/lesProjets.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/ressources-et-documentations", name="ressourcesdocumentions")
     */
    public function ressourcesdocumentions(): Response
    {
        return $this->render('home/ressourcesdocumentations.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/les-bonus-et-archives", name="lesBonusEtArchives")
     */
    public function lesBonusEtArchives(): Response
    {
        return $this->render('home/lesBonusEtArchives.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/agenda", name="agenda")
     */
    public function agenda(): Response
    {
        return $this->render('home/agenda.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/partenaires", name="partenaires")
     */
    public function partenaires(): Response
    {
        return $this->render('home/partenaires.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/le-festival", name="leFestival")
     */
    public function leFestival(): Response
    {
        return $this->render('home/leFestival.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
