<?php 

namespace App\Form;

class FormBuilder
{
    private array $fields = [];

    public function __construct(
        private string $action = '',
        private string $method = 'POST',
    )
    {
        
    }

    public function addField(string $name, string $label, string $type = 'text'): self
    {
        $this->fields[$name]= ['label' => $label, 'type' => $type];
        return $this;
    }

    public function addTextarea(string $name, string $label, int $rows, int $cols): self
    {
        $this->fields[$name] = ['label' => $label, 'type' => 'textarea' ,'rows' => $rows, 'cols' => $cols];
        return $this;
    }

    public function addSelect(string $name, string $label, array $options): self
    {
        $this->fields[$name] = ['label' => $label, 'type' => 'select', 'options' => $options];
        return $this;
    }

    public function addRadio(string $name, string $label, array $options): self
    {
        $this->fields[$name] = ['label' => $label, 'type' => 'radio', 'options' => $options];
        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }
    
    public function getAction(): string
    {
        return $this->action;
    }
    
    public function getMethod(): string
    {
        return $this->method;
    }
}