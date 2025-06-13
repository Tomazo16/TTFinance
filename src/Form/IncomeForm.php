<?php 

namespace App\Form;

use App\Entity\Account;
use Tomazo\Form\FormBuilder;
use Tomazo\Form\Validator\MaxLengthRule;
use Tomazo\Form\Validator\MinLengthRule;
use Tomazo\Form\Validator\NumericRule;
use Tomazo\Form\Validator\RequiredRule;

class IncomeForm extends AbstractForm
{
    public function createForm(): FormBuilder
    {
        $formBuilder = new FormBuilder();
        $formBuilder
            ->addField('name', 'Tytuł', 'text', [
                new RequiredRule(),
                new MaxLengthRule(40),
                new MinLengthRule(3)
            ])
            ->addField('value', 'Wartość', 'numeric',[
                new NumericRule()
            ])
            ->addSelect('account', 'Konto', $this->getData(Account::class),[
                new RequiredRule()
            ])
            ->addField('date', 'Data przychodu', 'date',[
                new RequiredRule()
            ]);

        return $formBuilder;
    }
}