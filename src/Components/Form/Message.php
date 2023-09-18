<?php

namespace Alexbirtwell\AbFilamentExtras\Components\Form;

use Closure;
use Filament\Forms\Components\Field;

class Message extends Field
{
    protected string $view = 'filament.fields.message';

    protected string|Closure|null $type = null;
    protected string|Closure|null $title = null;
    protected string|Closure|null $icon = null;
    protected string|Closure|null $message = null;

    protected function setUp(): void
    {
        $this->disableLabel();
    }

    public function primary(): self
    {
        $this->type('primary');

        return $this;
    }

    public function success(): self
    {
        $this->type('success');

        return $this;
    }

    public function warning(): self
    {
        $this->type('warning');

        return $this;
    }

    public function danger(): self
    {
        $this->type('danger');

        return $this;
    }

    public function info(): self
    {
        $this->type('info');

        return $this;
    }

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->evaluate($this->type);
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->evaluate($this->title) ?? (string) str($this->getName())
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();
    }

    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->evaluate($this->message);
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->evaluate($this->icon);
    }
}
