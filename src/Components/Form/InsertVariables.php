<?php

namespace App\View\Components\Backend\Filament\Fields;

use Filament\Forms\Components\TextInput;

class InsertVariables extends TextInput
{
    public array $variables;

    protected string $view = 'components.backend.filament.fields.insert-variables';

    public string $target;

    protected function setUp(): void
    {
        parent::setUp();
        $this->label('Available fields to insert');
        $this->helperText('Click on a field to insert it into the editor.');
        $this->dehydrated(false);
    }

    public function setVariables(array $variables): self
    {
        $this->variables = $variables;

        return $this;
    }

    public function setTarget(string $target): self
    {
        $this->target = $target;

        return $this;
    }
}
