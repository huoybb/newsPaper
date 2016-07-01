<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2016/7/1
 * Time: 13:26
 */

namespace App\forms;


use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Form;

class issueForm
{
    public static function buildForm(){
        $form = new Form();
        $form->add(new Text('Issue_Date'))
            ->add(new Text('Issue_Poster_URL'))
            ->add(new Text('URL'))
            ->add(new Submit('Submit'));
        return $form;
    }
}