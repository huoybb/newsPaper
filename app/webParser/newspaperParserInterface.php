<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/22
 * Time: 15:17
 */
namespace App\webParser;

interface newspaperParserInterface
{
    /**
     * @param $url
     * @return mixed  $issues[]=compact('url','title','date');
     */
    public function getLatestIssues($url);

    /**
     * @param $url
     * @return mixed  $pages[] = compact('page_num','url');
     */
    public function getPageInfoForIssue($url);

    /**
     * @param $url
     * @return string $img_src
     */
    public function getImageSrc($url);
}