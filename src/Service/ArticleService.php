<?php
namespace App\Service;


use GuzzleHttp\Client as Guzzle;
use KubAT\PhpSimple\HtmlDomParser;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleService{


    const APIKEY = "0f5ac6fc2aee41ba90a195c209dadef7";

    public function getArticleIds($firstQuery, $secondQuery)
    {
        $url = 'https://api.ozae.com/gnw/uc/raw-search?q='. $firstQuery.'+'.$secondQuery.'&date=20180101__20190101&key='.self::APIKEY;


        $client = new Guzzle();
        $res = $client->request('GET', $url);

        $body = $res->getBody();


        //TODO : SI il n'y a pas de resultat
        $ids = json_decode((string) $body)->articles_ids;

        $output = array_slice($ids, 0, 10);

        return $output;

    }


    public function getArticleById($id)
    {
        $url = 'https://api.ozae.com/gnw/article/'.$id.'?key='.self::APIKEY;

        $client = new Guzzle();
        $res = $client->request('GET', $url);

        $body = $res->getBody();

        $article = json_decode((string) $body);

        return $article;
    }


    public function getAvatarFromName($name){

        // the name of the people for the query
        $search_query = $name;
        //prepare the url for the query
        $search_query = urlencode( $search_query );
        //get the html from the url
        $html = HtmlDomParser::str_get_html(file_get_contents( "https://www.google.com/search?q=".$search_query."&tbm=isch&source=lnt&tbs=isz:lt,islt:svga&sa=X&&biw=1611&bih=838&dpr=2" ));

        $image_container = $html->find('div#search', 0);
        $images = $image_container->find('img');
        //return the src of image
        return $images[0]->getAttribute('src');

    }

}