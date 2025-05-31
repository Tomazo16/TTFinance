<?php 

namespace App\Form;

use Tomazo\Form\FormBuilder;
use Tomazo\Form\FormInterface;

class AccountForm implements FormInterface
{
    
    public static function createForm(): FormBuilder
    {
        $formBuilder = new FormBuilder();
        $formBuilder->addField('name', 'Nazwa');

        return $formBuilder;
    }

}