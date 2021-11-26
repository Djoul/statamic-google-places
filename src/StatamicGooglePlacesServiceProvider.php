<?php

namespace Nomala\StatamicGooglePlaces;

use Statamic\Providers\AddonServiceProvider;

class StatamicGooglePlacesServiceProvider extends AddonServiceProvider
{
    /*protected $tags = [
        \Jezzdk\StatamicGooglePlaces\Tags\Map::class,
        \Jezzdk\StatamicGooglePlaces\Tags\MapScript::class,
    ];

    protected $scripts = [
        __DIR__ . '/../dist/js/map.js',
    ];

    protected $fieldtypes = [
        \Jezzdk\StatamicGoogleMaps\Fieldtypes\GoogleMap::class,
    ];*/

    public function boot()
    {
        /*$this->externalScripts = [
            MapHelper::googleMapsScriptUrl()
        ];*/
        parent::boot();
    }

    public function register()
    {
        //
    }
}
