<?php

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/6/28
 * Time: 19:46
 */
class Statistics
{
    protected $IssueStat = null;
    protected $PageStat = null;
    protected $NewspaperStat = null;

    public function getIssueStat()
    {
        if($this->IssueStat) return $this->IssueStat;

        $TBD = \Issues::find('status = "TBD"')->count();
        $Total = \Issues::find()->count();
        $DONE = $Total - $TBD;
        $Completed = $this->transformToPercent($DONE / $Total * 100) ;
        return $this->IssueStat = compact('TBD','DONE','Total','Completed');
    }
    
    public function getPageStat()
    {
        if($this->PageStat) return $this->PageStat;

        $IMG = \Pages::find('status = "IMG"')->count();
        $URL = \Pages::find('status = "URL"')->count();
        $HTML =\Pages::find('status = "HTML"')->count();
        $Total = $IMG + $URL +$HTML;
        $Completed = $this->transformToPercent($IMG/$Total * 100);
        return $this->PageStat = compact('IMG','URL','Total','HTML','Completed');
    }

    public function getNewspaperStat()
    {
        if($this->NewspaperStat) return $this->NewspaperStat;
        
        $count = Newspapers::find()->count();
        return $this->NewspaperStat = compact('count');
    }


    private function transformToPercent($value)
    {
        return  sprintf("%01.2f",$value).'%';
    }


}