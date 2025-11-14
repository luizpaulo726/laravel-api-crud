<?php

namespace App\Providers;

use App\Repositories\Eloquent\AuthorRepository;
use App\Repositories\Eloquent\BookRepository;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define a URL customizada para o link de redefinição de senha
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            // pode ser o front, mas como é API, vamos gerar um link simples
            $baseUrl = config('app.url', 'http://localhost:8000');

            return $baseUrl . '/reset-password/' . $token
                . '?email=' . urlencode($notifiable->getEmailForPasswordReset());
        });
    }
}
