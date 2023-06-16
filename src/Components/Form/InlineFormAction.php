<?php

namespace App\View\Components\Backend\Filament\Fields;

use Closure;
use Filament\Forms\Components\Placeholder;
use Filament\Support\Actions\Concerns\CanOpenUrl;
use Filament\Support\Actions\Concerns\HasColor;

class InlineFormAction extends Placeholder
{
    use HasColor;
    use CanOpenUrl;

    protected string $view = 'components.backend.filament.fields.inline-form-action';
    public null|Closure|string $action = 'save';
    public string $align = 'right';

    protected function setUp(): void
    {
        parent::setUp();
        $this->disableLabel();
    }

    public function align(string $align): self
    {
        if (in_array($align, ['left', 'right'])) {
            $this->align = $align;
        }

        return $this;
    }

    public function action(string|Closure $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getActionName(): string|Closure|null
    {
        if ($this->getUrl()) {
            return null;
        }

        return is_string($this->action) ? $this->action : 'closureAction';
    }

    public function closureAction(): void
    {
        call_user_func($this->action);
    }

    public function getAlign(): string
    {
        return $this->align;
    }
}
