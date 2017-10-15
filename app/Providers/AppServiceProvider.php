<?php

namespace App\Providers;

use App\Message\MessageRepository;
use App\Message\DatabaseMessageRepository;
use App\Message\ElasticsearchMessageRepository;
use App\Users\UserRepository;
use App\Users\DatabaseUserRepository;
use App\Users\ElasticsearchUserRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

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

        $this->app->bind(MessageRepository::class, ElasticsearchMessageRepository::class);

        $this->app->bind(UserRepository::class, ElasticsearchUserRepository::class);

        $this->app->bind(Client::class, function () {
            return ClientBuilder::create()->setHosts(config('services.search.hosts'))->build();
        });
        
    }
}
