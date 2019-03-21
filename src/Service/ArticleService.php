<?php
namespace App\Service;


use GuzzleHttp\Client as Guzzle;

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

}