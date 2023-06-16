<?php

namespace App\Filament\Fields;

use Closure;
use Filament\Forms\Components\Field;

class HtmlSlot extends Field
{
    protected string $view = 'filament.fields.html-slot';

    protected string|Closure|null $class = null;
    protected string|Closure|null $content = null;
    protected string|Closure|null $icon = null;

    protected function setUp(): void
    {
        $this->disableLabel()->dehydrated(false);
    }

    public function getTitle(): ?string
    {
        return $this->evaluate($this->title) ?? (string) str($this->getName())
            ->kebab()
            ->replace(['-', '_'], ' ')
            ->ucfirst();
    }

    public function content(Closure|string|null $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->evaluate($this->content);
    }

    public function class(string $class): self
    {
        $this->class = $class;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->evaluate($this->class);
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
