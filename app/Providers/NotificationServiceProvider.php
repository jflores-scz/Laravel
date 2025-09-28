<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\Prestamo;
use App\Models\Deuda;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $lastPrestamo = null;
            $hasPendingDeudas = false;

            if (Session::has('cliente_id')) {
                $clienteId = Session::get('cliente_id');
                $lastPrestamo = Prestamo::where('cliente_id', $clienteId)->latest()->first();
                $hasPendingDeudas = Deuda::where('cliente_id', $clienteId)->where('estado', 'Pendiente')->exists();
            }

            $view->with(compact('lastPrestamo', 'hasPendingDeudas'));
        });
    }
}
