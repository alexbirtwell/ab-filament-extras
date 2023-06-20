<?php

namespace Alexbirtwell\AbFilamentExtras\Traits;

use Alexbirtwell\AbFilamentExtras\Models\Country;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use PhpParser\Node\Expr\Cast\Object_;

trait HasAddressSchema
{
    public static function getAddressFieldsSchema(): array
    {
        return [
                   TextInput::make('address_line_1')
                       ->label(config('business.address_labels.address_line_1'))
                       ->maxLength(255)
                       ->required(),
                    TextInput::make('address_line_2')
                        ->label(config('business.address_labels.address_line_2'))
                        ->maxLength(255),
                    TextInput::make('address_city')
                       ->label(config('business.address_labels.address_city'))
                       ->maxLength(255)
                       ->required(),
                    TextInput::make('address_region')
                       ->label(config('business.address_labels.address_region'))
                       ->maxLength(255)
                       ->required(),
                    TextInput::make('address_postal_code')
                       ->label(config('business.address_labels.address_postal_code'))
                       ->maxLength(12)
                       ->required(),
                    Select::make('address_country_id')
                        ->label('Country')
                        ->default(config('business.default_country_id'))
                        ->options(Country::all()->pluck('name', 'id'))
                        ->searchable(),

                ];
    }

    public static function migrationCommands(): void
    {
        $table = new Object_();//dummy
        $table->string("address_line_1")->nullable();
        $table->string("address_line_2")->nullable();
        $table->string("address_city")->nullable();
        $table->string("address_region")->nullable();
        $table->string("address_postal_code")->nullable();
        $table->foreignId("address_country_id")->nullable();
    }
}
