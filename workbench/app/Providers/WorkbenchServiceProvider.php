<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::view('/', 'welcome');
    }

    public function register()
    {
        //
    }

}