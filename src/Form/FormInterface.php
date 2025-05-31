<?php 

namespace App\Form;

interface FormInterface
{
    public static function createForm(): FormBuilder;
}