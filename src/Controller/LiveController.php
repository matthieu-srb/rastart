<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LiveController extends AbstractController
{
    /**
     * @Route("/live", name="live")
     */
    public function live(): Response
    {
        return $this->render('live/live.html.twig', [
            'controller_name' => 'LiveController',
        ]);
    }
    /**
     * @Route("/rastart-radio", name="liveRadio")
     */
    public function liveRadio(): Response
    {
        return $this->render('live/liveRadio.html.twig', [
            'controller_name' => 'LiveController',
        ]);
    }
}
