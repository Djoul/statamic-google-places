<?php

namespace Nomala\StatamicGooglePlaces\Tags;

use Nomala\StatamicGooglePlaces\GooglePlaces;
use Statamic\Tags\Tags;

class Place extends Tags
{
    /**
     * The {{ place }} tag.
     *
     * Usage:
     * {{ place }}
     * 
     * @return string|array
     */
    public function index()
    {
        if (!env('GOOGLE_MAPS_API_KEY')) {
            return 'Please add a GOOGLE_MAPS_API_KEY to the .env file';
        }

        return [];
    }

    /**
     * The {{ place:photos }} tag.
     *
     * @return string|array
     */
    public function photos()
    {
        $photos = [];

        $googlePlaces = new GooglePlaces();
        $photos = $googlePlaces->getPhotos('hotel recamier');

        return $photos;
    }
}