<?php

namespace Kowap\SendPulse;

use Illuminate\Support\ServiceProvider;
use Kowap\SendPulse\Contracts\SendPulseRepositoryInterface;
use Kowap\SendPulse\Repositories\SendPulseRepository;
use Kowap\SendPulse\Services\SendPulseService;

class SendPulseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/sendpulse.php' => config_path('sendpulse.php'),
            ], 'config');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/sendpulse.php', 'sendpulse');

        $this->app->singleton(SendPulseRepositoryInterface::class, function ($app) {
            return new SendPulseRepository($app['config']['sendpulse']);
        });

        $this->app->singleton('sendpulse', function ($app) {
            return new SendPulseService($app->make(SendPulseRepositoryInterface::class));
        });
    }
}
