<?php 

namespace App\Form;

use Tomazo\Form\FormBuilder;
use Tomazo\Form\Validator\FileMimeTypeRule;
use Tomazo\Form\Validator\MaxLengthRule;
use Tomazo\Form\Validator\MinLengthRule;
use Tomazo\Form\Validator\NumericRule;
use Tomazo\Form\Validator\RequiredRule;

class GoalForm extends AbstractForm
{
    public function createForm(): FormBuilder
    {
        $formBuilder = new FormBuilder();
        $formBuilder
            ->addField('name', 'Nazwa', 'text',[
                new RequiredRule(),
                new MaxLengthRule(40),
                new MinLengthRule(3)
            ])
            ->addField('value', 'Wartość', 'numeric',[
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