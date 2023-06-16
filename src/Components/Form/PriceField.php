<?php

namespace App\View\Components\Backend\Filament\Fields;

use App\Facades\Currency;
use Closure;
use Filament\Forms\Components\TextInput;

class PriceField extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->label('Price £ GBP')
            ->placeholder('0.00')
            ->mask(fn (TextInput\Mask $mask) => $mask->money('', ',', 2))
            ->rules(['numeric', 'min:0']);
    }

    public function setCurrency(
        string $currency = 'GBP',
        string $gbp_field_name = 'price',
        string $eur_field_name = 'euro_price',
        string $usd_field_name = 'dollar_price',
        string $terminology = 'Price'
    ): self {
        $this->reactive();
        $this->required();
        $this->afterStateUpdated(
            function (Closure $set, callable $get, $state) use (
                $currency,
                $gbp_field_name,
                $eur_field_name,
                $usd_field_name
            ): void {
                if ($get('convert_currency')) {
                    if ($currency != 'EUR') {
                        $set($eur_field_name, (string) round(Currency::convertFromTo((float) $state, $currency, 'EUR')));
                    }
                    if ($currency != 'USD') {
                        $set($usd_field_name, (string) round(Currency::convertFromTo((float) $state, $currency, 'USD')));
                    }
                    if ($currency != 'GBP') {
                        $set($gbp_field_name, (string) round(Currency::convertFromTo((float) $state, $currency, 'GBP')));
                    }
                }
            }
        );

        return match ($currency) {
            'EUR' => $this->label($terminology . ' € EUR'),
            'USD' => $this->label($terminology . ' $ USD'),
            default => $this->label($terminology . ' £ GBP'),
        };
    }
}
