<?php

declare(strict_types=1);

namespace MallardDuck\BladeBoxicons;

use BladeUI\Icons\Factory;
use Illuminate\Support\ServiceProvider;

class BladeBoxiconsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->callAfterResolving(Factory::class, function (Factory $factory) {
            $factory->add('boxicons-regular', [
                'path' => __DIR__.'/../resources/svg/regular',
                'prefix' => 'bx',
            ]);

            $factory->add('boxicons-solid', [
                'path' => __DIR__.'/../resources/svg/solid',
                'prefix' => 'bxs',
            ]);

            $factory->add('boxicons-logos', [
                'path' => __DIR__.'/../resources/svg/logos',
                'prefix' => 'bxl',
            ]);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/svg' => public_path('vendor/blade-boxicons'),
            ], 'blade-boxicons');
        }
    }
}
