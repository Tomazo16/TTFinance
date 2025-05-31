<?php 

namespace App\Form\Validator;

class RequiredRule implements ValidationRule
{
    public function validate(string $fieldName, mixed $value): ?string
    {
        return empty($value) ? ucfirst($fieldName) . " is required." : null;
    }
}