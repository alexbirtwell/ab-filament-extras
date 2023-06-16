# A collection of resuseable components for Filament Apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alexbirtwell/ab-filament-extras.svg?style=flat-square)](https://packagist.org/packages/alexbirtwell/ab-filament-extras)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/alexbirtwell/ab-filament-extras/run-tests?label=tests)](https://github.com/alexbirtwell/ab-filament-extras/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/alexbirtwell/ab-filament-extras/Check%20&%20fix%20styling?label=code%20style)](https://github.com/alexbirtwell/ab-filament-extras/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/alexbirtwell/ab-filament-extras.svg?style=flat-square)](https://packagist.org/packages/alexbirtwell/ab-filament-extras)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require alexbirtwell/ab-filament-extras
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="ab-filament-extras-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="ab-filament-extras-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="ab-filament-extras-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$ab-filament-extras = new Alexbirtwell\AbFilamentExtras();
echo $ab-filament-extras->echoPhrase('Hello, Alexbirtwell!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Alex Birtwell](https://github.com/alexbirtwell)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
