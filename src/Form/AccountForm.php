<?php 

namespace App\Form;

use Tomazo\Form\FormBuilder;
use Tomazo\Form\FormInterface;
use Tomazo\Form\Validator\MaxLengthRule;
use Tomazo\Form\Validator\MinLengthRule;
use Tomazo\Form\Validator\RequiredRule;

class AccountForm implements FormInterface
{
    
    public function createForm(): FormBuilder
    {
        $formBuilder = new FormBuilder('/ttfinance/acc/add');
        $formBuilder
        ->addField('name', 'Nazwa konta', 'text', [
            new RequiredRule(),
            new MaxLengthRule(40),
            new MinLengthRule(3)
        ]);

        return $formBuilder;
    }

}