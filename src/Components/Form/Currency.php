<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;
use Filament\Forms\Components\TextInput;
use Illuminate\Contracts\View\View;

class Currency extends TextInput
{
   public static function make(string $name): static
   {
       $static = parent::make($name);
       $static
           ->mask(fn (TextInput\Mask $mask) => $mask
                ->numeric()
                ->decimalPlaces(2) // Set the number of digits after the decimal point.
                ->decimalSeparator('.') // Add a separator for decimal numbers.
                ->minValue(0) // Set the minimum value that the number can be.
                ->normalizeZeros() // Append or remove zeros at the end of the number.
                ->thousandsSeparator(',') // Add a separator for thousands.
        );
       if($currency = session()->get('currency')) {
           $currency->isSymbolFirst() ? $static->prefix($currency->getSymbol()) : $static->suffix($currency->getSymbol());
       }
       return $static;
   }

}


