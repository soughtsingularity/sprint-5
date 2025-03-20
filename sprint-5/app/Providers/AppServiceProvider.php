<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Laravel\Passport\Passport;

Passport::hashClientSecrets();

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Request::macro('expectsJson', fn () => true);
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        Passport::enablePasswordGrant();
        Passport::hashClientSecrets();
        Passport::enableImplicitGrant();



    }
}
