<?php

namespace App\Providers;

use App\Models\Injury;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Compartir lesiones activas con todas las vistas
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $activeInjuries = Injury::with(['player.team'])
                    ->where('active', true)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $view->with('globalInjuries', $activeInjuries);
            }
        });
    }
}