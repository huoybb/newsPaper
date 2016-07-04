<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/4
 * Time: 7:29
 */

namespace App\webParser;


class parserManager implements newspaperParserInterface
{
    /**
     * @var array 将所有的webParser都放在这，统一管理
     */
    protected $parsers ;

    /**
     * parserManager constructor.
     * @param array $parsers
     */
    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }


    /**
     * @param $url
     * @return newspaperParserInterface
     */
    public function getParser($url)
    {
        if(! $url) throw new \Exception('url is null, please check your newspaper\'s url');
        foreach ($this->parsers as $pattern => $parser){
            if(preg_match('|'.$pattern.'|',$url)) return new $parser;
        }
        throw new \Exception('could not find WebParser for '.$url);
    }

    /**
     * @param $url
     * @return mixed  $issues[]=compact('url','title','date');
     */
    public function getLatestIssues($url)
    {
        return $this->getParser($url)->getLatestIssues($url);
    }

    /**
     * @param $url
     * @return mixed  $pages[] = compact('page_num','url');
     */
    public function getPageInfoForIssue($url)
    {
        return $this->getParser($url)->getPageInfoForIssue($url);
    }

    /**
     * @param $url
     * @return string $img_src
     */
    public function getImageSrc($url)
    {
        return $this->getParser($url)->getImageSrc($url);
    }
}