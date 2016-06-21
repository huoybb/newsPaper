<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/20
 * Time: 12:45
 */

namespace App\webParser;


use Goutte\Client;

class myCrawler
{
    protected $client;

    /**
     * myParser constructor.
     * @param $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * @param $url
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public static function getCrawler($url)
    {
        $parser = (new self(new Client()));

        //下面两行，避免了SSL的验证，在正式的web环境中已经设置了，但在命令行中可以直接取消掉验证
        $httpClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
        $parser->client->setClient($httpClient);

        $crawler = $parser->client->request('get',$url);
        return $crawler;
    }
}