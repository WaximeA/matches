<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MatchesController extends AbstractController
{



    const API_TOKEN = "0f5ac6fc2aee41ba90a195c209dadef7";

    /**
     * @Route("/matches", name="matches")
     */
    public function index(Request $request)
    {

        //retrieve cookies from the request
        $cookiesRequest = $request->cookies;

        //if the cookies contain the USER_TOKEN && exists
        if (!$cookiesRequest->has('USER_TOKEN') && empty($user))
        {
            return $this->redirectToRoute("landing_index");
        }

        return $this->render('matches/index.html.twig', [
            'controller_name' => 'MatchesController',
        ]);
    }
}
