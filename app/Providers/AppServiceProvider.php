<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ServiceContainer;
use App\Services\SettingsService;
use Modules\SiteInfo\Repositories\ModelRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(ServiceContainer::class, function ($app) {
            return new ServiceContainer(
                $app->make(\App\Services\SimpleCrudService::class),
                $app->make(\Modules\Lang\Repositories\ModelRepository::class),
                $app->make(\App\Services\StatusService::class),
                $app->make(\App\Services\RemoveService::class),
                $app->make(\App\Services\ImageService::class),
            );
        });
        $this->app->singleton(SettingsService::class, function ($app) {
            return new SettingsService($app->make(ModelRepository::class));
        });
    }
}
