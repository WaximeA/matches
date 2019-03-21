<?php

namespace App\Controller;

use App\Entity\History;
use App\Repository\HistoryRepository;
use App\Repository\UserRepository;
use App\Service\ArticleService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HotMatchController extends AbstractController
{


    /**
     * @Route("/hot/match/{firstQuery}/{secondQuery}", name="hot_match_process")
     */
    public function process_query($firstQuery,$secondQuery, Request $request, UserRepository $userRepository, UserService $userServicen)
    {
        //retrieve cookies from the request
        $cookiesRequest = $request->cookies;
        // Search for a user with this cookies
        $user = $userRepository->findOneBy(["token" => $cookiesRequest->get("USER_TOKEN") ]);

        $entityManager = $this->getDoctrine()->getManager();

        $token = $userServicen->gen_uuid();

        $history = new History();

        $history
            ->setUuid($token)
            ->setUser($user)
            ->setFirstQuery($firstQuery)
            ->setSecondQuery($secondQuery)
            ->setInsDate(new \DateTime('now'))
            ->setViews(0);

        $entityManager->persist($history);

        $entityManager->flush();

        return $this->redirectToRoute("hot_match_page", ["uuid" => $token]);
    }

    /**
     * @Route("/hot-matches/{uuid}", name="hot_match_page")
     */
    public function index($uuid, HistoryRepository $historyRepository, ArticleService $articleService)
    {

        $array_articles = [];

        $matches = $historyRepository->findOneBy(["uuid" => $uuid ]);

        if ($matches){

            $ids = $articleService->getArticleIds($matches->getFirstQuery(), $matches->getSecondQuery());


            foreach ($ids as $id){
                array_push($array_articles, $articleService->getArticleById($id));
            }

            dump($array_articles);

            return $this->render("hot_match/index.html.twig", [
                "firstQuery" => $matches->getFirstQuery(),
                "secondQuery" => $matches->getSecondQuery(),
                "article" => $array_articles,
            ]);

        }

        return $this->render('matches/index.html.twig');


    }

}
