<?php
namespace App\myPlugins;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Pages;

/**
 * 这个对象将常见的一些工具集成在这个对象中
 * 有一些直接在volt中变成函数
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/8/29
 * Time: 14:18
 */
class myTools
{
    public static function isOnline()
    {
        return @fopen("http://www.baidu.com/", "r");//判断是否连上网
    }
    
    public static function formatDate($time)
    {
        if($time == null) return null;
        if (preg_match('/([0-9]+)年([0-9]+)月([0-9]+)日/m', $time, $regs)) {
            return Carbon::create($regs[1],$regs[2],$regs[3])->format('Y-m-d');
        }
        return Carbon::createFromTimestamp(strtotime($time))->format('Y-m-d');
    }



    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }



    function formatTimeUnit($time){
        if($time >86400){
            $time = number_format($time / 86400,2).' 天';
        }elseif ($time > 3600){
            $time = number_format($time / 3600,2).' 小时';
        }elseif ($time > 60){
            $time = number_format($time / 60,2).' 分钟';
        }elseif ($time > 0){
            $time=$time.' 秒';
        }else {
            $time = '0秒';
        }
        return $time;
    }
    static public function isDirOrMkdir($path)
    {
        if (! is_dir($path)) mkdir($path);
        return $path;
    }

    static public function makePath($uploaddir, $time)
    {
        $year = date('Y', $time);
        $month = date('m', $time);
        $day = date('d', $time);

        $path = static::isDirOrMkdir($uploaddir . '/');
        $path = static::isDirOrMkdir($path . $year . '/');
        $path = static::isDirOrMkdir($path . $month . '/') ;
        $path = static::isDirOrMkdir($path . $day . '/') ;
        return $path;
    }

    public static function storeAttachment(\Phalcon\Http\Request\File $attachment)
    {
        $uploadDir = 'files'; //上传路径的设置
        $time = time();
        $path = static::makePath($uploadDir,$time);

        $ext = preg_replace('%^.*?(\.[\w]+)$%', "$1", $attachment->getName()); //获取文件的后缀
        $url = md5($attachment->getName());

        $filename = $path . $time . $url . $ext;

        $attachment->moveTo($filename);

        return $filename;
    }
    public static function downloadImage($url,$uploadDir = null){
//        $url = urlencode($url);
        $url = preg_replace('|\s|','%20',$url);//解决url中有空格的问题
        $guzzle = new Client();
        try{
            $file = $guzzle->request('get',$url)->getBody();
            //        $file = file_get_contents($url);

            if($uploadDir == null){
                if(getMyEnv() == 'web') $uploadDir = 'files';
                if(getMyEnv() == 'cli') $uploadDir = 'public/files';
            }
            $time = time();
            $path = static::makePath($uploadDir,$time);

            $ext = preg_replace('%^.*?(\.[\w]+)$%', "$1", basename($url)); //获取文件的后缀
            $url = md5(basename($url));

            $filename = $path . $time . $url . $ext;

            if(!$file){
                return null;
            }
            file_put_contents($filename,$file);

            if(getMyEnv() == 'web') return 'public/'.$filename;
            if(getMyEnv() == 'cli') return $filename;

            return $filename;

        }catch (\Exception $e){
            echo 'could not download page: '.$url.PHP_EOL;
        }
        return null;
    }
    /*
     * 接受任何编码，并将之变成UTF-8的编码
     * 这个函数在抓取万方数据有用
     *
     */
    static function correct_encoding($text) {
        $current_encoding = mb_detect_encoding($text, 'auto');
        $text = iconv($current_encoding, 'UTF-8', $text);
        return $text;
    }

    /*
     * 去除页面中的各种不必要的标签
     *
     *
     */
    static function html2txt($document){
        $search = array('@<script[^>]*?>.*?</script>@si',  // Strip out javascript

            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
        );
        $text = preg_replace($search, '', $document);
        return $text;
    }

    public static function cut($string,$maxLength=50){
//        $result = mb_substr($string,0,$maxLength,'utf-8');
        $result = mb_strcut($string,0,$maxLength,'utf-8');
        if(mb_strlen($string) > $maxLength) $result .= ' ...';
        return $result;
    }

    public static function my_substr($str, $start, $len)
    {
        $tmpstr = "";
        $strlen = $start + $len;
        for($i = 0; $i < $strlen; $i++)
        {
            if( ord( substr($str, $i, 1) ) > 0xa0 )
            {
                $tmpstr .= substr($str, $i, 3);
                $i += 2;
            } else
                $tmpstr .= substr($str, $i, 1);
        }
        return $tmpstr;
    }

    public static function camelize($title){
        $words = explode(' ',trim($title));
        foreach($words as $key => $word){
            $words[$key] = \Phalcon\Text::camelize($word);
        }
        return implode(' ',$words);
    }

    public function getNewspapers()
    {
        return \Newspapers::find();
    }
    public function collection(array $vars)
    {
        return collect($vars);
    }

    public static function getColumns(Pages $page)
    {
        $Issue = $page->getIssue();
        return \Columns::query()
            ->where('newspaper_id = :id:',['id'=>$Issue->newspaper_id])
            ->execute();
    }





}