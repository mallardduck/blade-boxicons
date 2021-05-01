# Blade Boxicons

A package to easily make use of [Boxicons](https://github.com/atisawd/boxicons) in your Laravel Blade views.

For a full list of available icons see [the SVG directory](resources/svg) or preview them at [boxicons.com](https://boxicons.com/). Boxicons are originally developed by [Atisa](https://github.com/atisawd).

## Requirements

- PHP 7.4 or higher
- Laravel 8.0 or higher

## Installation

```bash
composer require mallardduck/blade-boxicons
```

## Usage

Icons can be used as self-closing Blade components which will be compiled to SVG icons:

```blade
<x-bx-check-shield/>
```

You can also pass classes to your icon components:

```blade
<x-bx-check-shield class="w-6 h-6 text-gray-500"/>
```

And even use inline styles:

```blade
<x-bx-check-shield style="color: #555"/>
```

The solid icons can be referenced like this:

```blade
<x-bxs-check-shield/>
```

The logo icons can be referenced like this:

```blade
<x-bxl-github/>
```

### Raw SVG Icons

If you want to use the raw SVG icons as assets, you can publish them using:

```bash
php artisan vendor:publish --tag=blade-boxicons --force
```

Then use them in your views like:

```blade
<img src="{{ asset('vendor/blade-boxicons/regular/check-shield.svg') }}" width="10" height="10"/>
```

### Blade Icons

Blade Boxicons uses Blade Icons under the hood. Please refer to [the Blade Icons readme](https://github.com/blade-ui-kit/blade-icons) for additional functionality.

## Changelog

Check out the [CHANGELOG](CHANGELOG.md) in this repository for all the recent changes.

## Maintainers

Blade Boxicons was originally developed and maintained by [João Oliveira](https://joliveira.pt).
This fork has been adopted by [Dan Pock](https://opendor.me/@mallardduck).

Blade Icons is developed and maintained by [Dries Vints](https://driesvints.com).

## License

Blade Boxicons is open-sourced software licensed under [the MIT license](LICENSE.md).
