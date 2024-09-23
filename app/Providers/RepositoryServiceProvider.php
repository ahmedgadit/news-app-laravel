<?php

namespace App\Providers;

use App\Models\Platform;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\ArticleInterface;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\PlatformInterface;
use App\Repositories\Interfaces\SourceInterface;
use App\Repositories\PlatformRepository;
use App\Repositories\SourceRepository;
use Illuminate\Support\ServiceProvider;
use PHPUnit\TextUI\Configuration\Source;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $managers = [
            CategoryInterface::class => CategoryRepository::class,
            SourceInterface::class => SourceRepository::class,
            ArticleInterface::class => ArticleRepository::class,
            PlatformInterface::class => PlatformRepository::class,
        ];

        foreach ($managers as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
