<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\CartaoRepositoryInterface;
use App\Repositories\Eloquent\CartaoRepository;
use App\Repositories\Interfaces\UsuarioRepositoryInterface;
use App\Repositories\Eloquent\UsuarioRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartaoRepositoryInterface::class, CartaoRepository::class);
        $this->app->bind(UsuarioRepositoryInterface::class, UsuarioRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
