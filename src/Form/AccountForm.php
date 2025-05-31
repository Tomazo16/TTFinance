<?php 

namespace App\Form;

use App\Form\FormBuilder;

class AccountForm implements FormInterface
{
    
    public static function createForm(): FormBuilder
    {
        $formBuilder = new FormBuilder();
        $formBuilder->addField('name', 'Nazwa');

        return $formBuilder;
    }

}