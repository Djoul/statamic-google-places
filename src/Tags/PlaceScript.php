<?php

namespace Nomala\StatamicGooglePlaces\Tags;

use Nomala\StatamicGooglePlaces\Helpers\PlaceHelper;
use Statamic\Tags\Tags;

class PlaceScript extends Tags
{
    protected static $handle = 'place_script';

    /**
     * The {{ place_script }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        return '<script src="' . PlaceHelper::googleMapsUrl() . '" type="text/javascript" async defer></script>';
    }
}