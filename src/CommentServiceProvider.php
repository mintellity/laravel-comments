<?php

namespace Mintellity\Comments;

use App\Models\Receipt;
use Livewire\Livewire;
use Mintellity\Comments\Http\Livewire\CommentTable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CommentServiceProvider extends PackageServiceProvider
{
//
//    public function register()
//    {
//        $this->app->bind(Receipt::class);
//    }


    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-comments')
            ->hasViews()
            ->hasAssets()
            ->hasMigration('create_comments_table')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishAssets()
                    ->publishMigrations()
                    ->publishConfigFile()
                    ->askToRunMigrations();
            });
    }

    public function bootingPackage(): void
    {
        Livewire::component('comment-table', CommentTable::class); // register the Livewire component
//
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'comment-package'); // Livewire blade
//
//        $this->publishes([
//            __DIR__.'/../resources/views' => resource_path('views/vendor/comment-package'),
//        ], 'comment-package-views');
    }
}
