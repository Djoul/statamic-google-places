<?php

namespace Nomala\StatamicGooglePlaces;

use SKAgarwal\GoogleApi\ServiceProvider;
use Statamic\Providers\AddonServiceProvider;

class StatamicGooglePlacesServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        \Nomala\StatamicGooglePlaces\Tags\Place::class,
    ];

    public function boot()
    {
        parent::boot();

        $this->bootAddonConfig();
    }

    protected function bootAddonConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/places.php', 'statamic.places');

        $this->publishes([
            __DIR__.'/../config/places.php' => config_path('statamic/places.php'),
        ], 'places-config');

        return $this;
    }

    public function register()
    {
        $this->app->register(ServiceProvider::class);
    }
}
