<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use KubAT\PhpSimple\HtmlDomParser;



/**
 * @Route("/api", name="index_api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/getImages/{nameInput}", name="get_images")
     */
    public function getImages($nameInput)
    {
        // the name of the people for the query
        $search_query = $nameInput;
        //prepare the url for the query
        $search_query = urlencode( $search_query );
        //get the html from the url
        $html = HtmlDomParser::str_get_html(file_get_contents( "https://www.google.com/search?q=".$search_query."&tbm=isch&source=lnt&tbs=isz:lt,islt:svga&sa=X&&biw=1611&bih=838&dpr=2" ));

        $image_container = $html->find('div#search', 0);
        $images = $image_container->find('img');
        // create an aray for store the img url
        $result = [ "data" =>  $images[0]->getAttribute('src') ];
        //return the array in Json
        return new JsonResponse($result, 200);
    }
}
