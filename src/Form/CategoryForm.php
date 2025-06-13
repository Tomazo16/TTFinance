<?php 

namespace App\Form;

use Tomazo\Form\FormBuilder;
use Tomazo\Form\FormInterface;
use Tomazo\Form\Validator\FileMimeTypeRule;
use Tomazo\Form\Validator\MaxLengthRule;
use Tomazo\Form\Validator\MinLengthRule;
use Tomazo\Form\Validator\NumericRule;
use Tomazo\Form\Validator\RequiredRule;

class CategoryForm implements FormInterface
{
    public function createForm(): FormBuilder
    {
        $formBuilder = new FormBuilder();
        $formBuilder
            ->addField('name', 'Nazwa', 'text', [
                new RequiredRule(),
                new MaxLengthRule(20),
                new MinLengthRule(3)
            ])
            ->addField('budget', "Budżet", 'numeric', [
                new RequiredRule(),
                new NumericRule()
            ])
            ->addFile('img_src', 'Ikona', false, [
                new FileMimeTypeRule([
                 	'image/jpeg',
                    'image/png',
                    'image/webp'
                ])
            ],
            'assets/media/account/'
            );


        return $formBuilder;
    }
}