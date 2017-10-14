<?php

namespace App\Providers;

use App\Message\MessageRepository;
use App\Users\UserRepository;
use App\Users\DatabaseUserRepository;
use Illuminate\Support\ServiceProvider;
use App\Message\DatabaseMessageRepository;

class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

        $this->app->bind(MessageRepository::class, function() {
            return new DatabaseMessageRepository();
        });

        $this->app->bind(UserRepository::class, function() {
            return new DatabaseUserRepository();
        });
        
    }
}
