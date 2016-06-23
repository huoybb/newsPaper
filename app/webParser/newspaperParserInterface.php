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
    public function getLatestIssues($url);

    public function getPageInfoForIssue($url);

    public function getImageSrc($url);
}