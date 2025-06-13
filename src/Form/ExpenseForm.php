<?php 

namespace App\Form;

use App\Config\DoctrineConfig;
use App\Entity\Account;
use App\Entity\Category;
use App\Entity\RecurringPayment;
use Tomazo\Form\FormBuilder;
use Tomazo\Form\Validator\MaxLengthRule;
use Tomazo\Form\Validator\MinLengthRule;
use Tomazo\Form\Validator\NumericRule;
use Tomazo\Form\Validator\RequiredRule;

class ExpenseForm extends AbstractForm
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
                new RequiredRule(),
                new NumericRule()
            ])
            ->addField('date', 'Data wydatku', 'date',[
                new RequiredRule()
            ])
            ->addSelect('category', 'Kategoria', $this->getData(Category::class))
            ->addSelect('account', 'Konto', $this->getData(Account::class))
            ->addSelect('recurringPayment', 'Płatność cykliczna', $this->getData(RecurringPayment::class));

        return $formBuilder;
    }


}