<?php

namespace Nomala\StatamicGooglePlaces;

//use SKAgarwal\GoogleApi\Providers\EventServiceProvider;
use SKAgarwal\GoogleApi\ServiceProvider;
use Statamic\Providers\AddonServiceProvider;

class StatamicGooglePlacesServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        \Nomala\StatamicGooglePlaces\Tags\Place::class,
    ];

    /*
    protected $scripts = [
        __DIR__ . '/../dist/js/map.js',
    ];

    protected $fieldtypes = [
        \Jezzdk\StatamicGoogleMaps\Fieldtypes\GoogleMap::class,
    ];*/

    //SKAgarwal\GoogleApi\ServiceProvider::class,

    public function boot()
    {
        /*$this->externalScripts = [
            MapHelper::googleMapsScriptUrl()
        ];*/
        parent::boot();
    }

    public function register()
    {
        $this->app->register(ServiceProvider::class);
    }
}
