<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Contracts\View\View;

class ModelLookup extends Field
{
    protected string $view = 'forms.components.model-lookup';
    protected mixed $searchModel;
    protected $term = '';

    public function render(): View
    {
        $users = $this->searchModel::search(data_get($this->getLivewire(), $this->getStatePath()."_text"))->paginate(10);

        $data = [
            'results' => $users,
        ];

        return view(
                $this->getView(),
                array_merge(
                    $this->data(),
                    $data,
                    isset($this->viewIdentifier) ? [$this->viewIdentifier => $this] : [],
                ),
            );

    }

    public function setSearchModel(mixed $model_name) {
            $this->searchModel = $model_name;
            return $this;
    }

}


