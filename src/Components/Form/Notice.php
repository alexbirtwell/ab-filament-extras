<?php

namespace App\Forms\Components;

use App\Actions\SearchForVenueAction;
use Filament\Forms\Components\Field;
use Illuminate\Contracts\View\View;
use Illuminate\View\ComponentAttributeBag;

class Notice extends Field
{
    protected string $view = 'forms.components.notice';
    public array $data;

    public static function make(string $name): static
    {
        $self = parent::make($name);
        $self->disableLabel();
        return $self;
    }

    public function render(): View
    {
        return view(
                $this->getView(),
                array_merge(
                    ['attributes' => new ComponentAttributeBag()],
                    $this->data,
                    $this->extractPublicProperties(),
                    $this->extractPublicMethods(),
                    isset($this->viewIdentifier) ? [$this->viewIdentifier => $this] : [],
                    $this->viewData,
                ),
            );

    }

    public function type(string $type): self
    {
        $this->data['message_type'] = $type;

        return $this;
    }

    public function title(string $title): self
    {
        $this->data['message_title'] = $title;

        return $this;
    }

    public function message(string $message): self
    {
        $this->data['message_message'] = $message;

        return $this;
    }



}


