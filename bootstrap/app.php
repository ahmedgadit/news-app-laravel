<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);

        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('migrate')->everyMinute()->when(function () {
            info('Running migrate command');
            $categoryDbExists = DB::table('categories')->exists();
            $sourceDbExists = DB::table('sources')->exists();
            $articleDbExists = DB::table('articles')->exists();
            $platformDbExists = DB::table('platforms')->exists();
            if (!$categoryDbExists && !$sourceDbExists && !$articleDbExists && !$platformDbExists) {
                return true;
            }
            info('Skipping migrate command');
            return false;
        });
        $schedule->command('db:seed')->everyMinute()->when(function () {
            info('Running db:seed command');
            $countSources = DB::table('sources')->count();
            $countPlatforms = DB::table('platforms')->count();
            if ($countSources === 0 && $countPlatforms === 0) {
                return true;
            }
            info('Skipping db:seed command');
            return false;
        });
        $schedule->command('app:setup-news-data')->everyMinute()->when(function(){
            info('Running setup news data command');
            $countCategories = DB::table('categories')->count();
            $countSources = DB::table('sources')->count();
            $countArticles = DB::table('articles')->count();
            if($countArticles === 0 && $countSources <= 2) {
                return true;
            }
            info('Skipping setup news data command');
            return false;
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
