<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;


class LandingController extends AbstractController
{
    /**
     * @Route("/", name="landing_index")
     */
    public function index(UserService $userService, UserRepository $userRepository, Request $request)
    {

        //retrieve cookies from the request
        $cookiesRequest = $request->cookies;
        // Search for a user with this cookies
        $user = $userRepository->findOneBy(["token" => $cookiesRequest->get("USER_TOKEN") ]);

        //if the cookies contain the USER_TOKEN && exists
        if ($cookiesRequest->has('USER_TOKEN') && !empty($user))
        {
            return $this->render('matches/index.html.twig');
        }

        //get the entityManager
        $entityManager = $this->getDoctrine()->getManager();

        //Create new Token With guuid V4
        $token = $userService->gen_uuid();

        //retrieve IP adress
        $ip_adress = $_SERVER['REMOTE_ADDR'];

        //Create new User
        $User = new User();
        $User
            ->setToken($token)
            ->setIpAdress($ip_adress)
            ->setInsDate(new \DateTime('now'));

        $entityManager->persist($User);
        $entityManager->flush();


        // Create new cookies for start storing the session's user
        $cookie = Cookie::create("USER_TOKEN",$token, strtotime('now + 30 minutes') );
        // attach render to response
        $response = $this->render('landing/index.html.twig');
        //attach cookie to response
        $response->headers->setCookie($cookie);
        //return cookie
        return $response;
    }
}
