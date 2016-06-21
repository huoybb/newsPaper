<?php
namespace App\events;
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/3/31
 * Time: 9:33
 */
class myTestEvent
{
    private $data;

    /**
     * myTestEvent constructor.
     * @param array $array
     */
    public function __construct($data)
    {

        $this->data = $data;
    }
    public function getData()
    {
        return $this->data;
    }

}