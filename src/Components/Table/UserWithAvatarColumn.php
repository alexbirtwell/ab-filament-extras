<?php

namespace Alexbirtwell\AbFilamentExtras\Components\Table;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\View\View;
use function App\Tables\Components\session;

class UserWithAvatarColumn extends TextColumn
{
   public static function make(string $name): static
   {
       $static = parent::make($name);
       $static->formatStateUsing(fn ($state) => $state ? number_format($state, 2) : $state);
       if($currency = session()->get('currency')) {
           $currency->isSymbolFirst() ? $static->prefix($currency->getSymbol()) : $static->suffix($currency->getSymbol());
       }
       return $static;
   }

}


