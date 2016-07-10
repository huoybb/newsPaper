<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/10
 * Time: 21:57
 */

namespace App\myPlugins;


use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Forms\Form;
use Tags;

class myForm extends Form
{
    protected $exludedFields = [];

    /**
     * tagForm constructor.
     * @param null $model
     */
    public function __construct(myModel $model)
    {
        parent::__construct($model);
        $this->initialize($model);
    }

    protected function initialize(myModel $model)
    {
        $fields = [];
        $metaDataTypes = $model->getModelsMetaData()->getDataTypes($model);
        foreach ($metaDataTypes as $column => $dataType) {
            if (!in_array($column, $this->exludedFields)) {
                if ($dataType <> 6) {
                    $this->add(new Text($column));
                } else {
                    $this->add(new TextArea($column));
                }

                $fields[] = $column;
            };
        }

        $this->fields = $fields;

        if ($model->id) {
            $this->add(new Submit('修改'));
        } else {
            $this->add(new Submit('增加'));
        }
    }
}