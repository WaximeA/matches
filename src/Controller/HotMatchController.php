<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HotMatchController extends AbstractController
{
    /**
     * @Route("/hot/match", name="hot_match")
     */
    public function index()
    {
        return $this->render('hot_match/index.html.twig', [
            'controller_name' => 'HotMatchController',
        ]);
    }
}
