<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchesController extends AbstractController
{



    const API_TOKEN = "0f5ac6fc2aee41ba90a195c209dadef7";

    /**
     * @Route("/matches", name="matches")
     */
    public function index()
    {


        return $this->render('matches/index.html.twig', [
            'controller_name' => 'MatchesController',
        ]);
    }
}
