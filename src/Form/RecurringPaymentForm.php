<?php 

namespace App\Form;

use App\Entity\Category;
use Tomazo\Form\FormBuilder;
use Tomazo\Form\Validator\MaxLengthRule;
use Tomazo\Form\Validator\MinLengthRule;
use Tomazo\Form\Validator\NumericRule;
use Tomazo\Form\Validator\RequiredRule;

class RecurringPaymentForm extends AbstractForm
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
        ->addRadio('is_active', 'Status',[
            1 => 'tak',
            2 => 'nie'
        ],
        [
            new RequiredRule()
        ])
        ->addSelect('billing', 'Rozliczenie',[
            "Monthly" => 'Miesięczne',
            "2-Monthly" => "2 miesiące",
            "3-Monthly" => "3 miesiące",
            "6-Monthly" => "6 miesięcy",
            "Yearly" => "Roczne",
        ],[
            new RequiredRule()
        ])
        ->addField('value', 'Wartość', 'numeric',[
            new NumericRule()
        ])
        ->addSelect('category', 'Kategoria:', $this->getData(Category::class));

        return $formBuilder;
    }
}