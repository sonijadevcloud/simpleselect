<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\SystemSettings;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();  

        // Pobierz wartość strefy czasowej z bazy danych
        // $timezone = SystemSettings::where('name', 'app_timezone')->value('value');
        $apptitle = SystemSettings::where('name', 'app_title')->value('value');


        // Ustaw strefę czasową w konfiguracji Laravela
        config(['app.title' => $apptitle]);
    }
}
