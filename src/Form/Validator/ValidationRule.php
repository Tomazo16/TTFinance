<?php 

namespace App\Form\Validator;

interface ValidationRule
{
    public function validate(string $fieldName, mixed $value): ?string;
}