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
        // Register the Livewire component
        Livewire::component('comment-table', CommentTable::class);

        // Livewire blade
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'comment-package');
    }
}
