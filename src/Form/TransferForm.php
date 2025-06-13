<?php 

namespace App\Form;

use App\Entity\Account;
use App\Entity\Goal;
use Tomazo\Form\FormBuilder;
use Tomazo\Form\Validator\MaxLengthRule;
use Tomazo\Form\Validator\MinLengthRule;
use Tomazo\Form\Validator\NumericRule;
use Tomazo\Form\Validator\RequiredRule;

class TransferForm extends AbstractForm
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
        ->addField('value', 'Wartość transferu', 'numeric',[
            new NumericRule()
        ])
        ->addField('date', 'Data transferu', 'date',[
            new RequiredRule()
        ])
        ->addSelect('from_account', 'Z konta', $this->getData(Account::class))
        ->addSelect('to_account', 'Na konto', $this->getData(Account::class))
        ->addSelect('goal', 'Cel', $this->getData(Goal::class));

        return $formBuilder;
    }
}