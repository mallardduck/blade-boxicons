<?php

declare(strict_types=1);

namespace MallardDuck\BladeBoxicons\Tests;

use BladeUI\Icons\BladeIconsServiceProvider;
use MallardDuck\BladeBoxicons\BladeBoxiconsServiceProvider;
use Orchestra\Testbench\TestCase;
use Spatie\Snapshots\MatchesSnapshots;

class CompilesIconsTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function it_compiles_a_single_anonymous_component()
    {
        $result = svg('bx-check-shield')->toHtml();
        $this->assertMatchesHtmlSnapshot($result);
    }

    /** @test */
    public function it_can_add_classes_to_icons()
    {
        $result = svg('bx-check-shield', 'w-6 h-6 text-gray-500')->toHtml();
        $this->assertMatchesHtmlSnapshot($result);
    }

    /** @test */
    public function it_can_add_styles_to_icons()
    {
        $result = svg('bx-check-shield', ['style' => 'color: #555'])->toHtml();
        $this->assertMatchesHtmlSnapshot($result);
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeIconsServiceProvider::class,
            BladeBoxiconsServiceProvider::class,
        ];
    }
}
