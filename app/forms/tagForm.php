<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/10
 * Time: 6:16
 */

namespace App\forms;


use App\myPlugins\myModel;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Tags;

class tagForm
{
    protected $tag = null;
    protected $form;

    /**
     * tagForm constructor.
     * @param null $tag
     */
    public function __construct(Tags $tag)
    {
        if($tag->id){
            $this->tag = $tag;
            $this->form = new Form($tag);
        }else{
            $this->form = new Form();
        }
        $this->initialize($tag);
    }

    private function initialize(myModel $model)
    {
        $form = $this->form;
        $fields =[];
        $metaDataTypes = $model->getModelsMetaData()->getDataTypes($model);
        foreach($metaDataTypes as $column=>$dataType){
            if(!in_array($column,['created_at','updated_at','id','password','remember_token'])){
                if($dataType <> 6){
                    $form->add(new Text($column));
                }else{
                    $form->add(new TextArea($column));
                }

                $fields[]=$column;
            };
        }

        $form->fields =$fields;

        if($model->id){
            $form->add(new Submit('修改'));
        }else{
            $form->add(new Submit('增加'));
        }
        $this->form = $form;
    }
    public function getForm()
    {
        return $this->form;
    }



}