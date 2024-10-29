<?php

namespace Mintellity\Comments;

use Livewire\Livewire;
use Mintellity\Comments\Http\Livewire\CommentSection;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CommentServiceProvider extends PackageServiceProvider
{
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
        Livewire::component('comment-section', CommentSection::class); // register the Livewire component

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'comment-package'); // Livewire blade

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations'); // Load migrations
    }
}