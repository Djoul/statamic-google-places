<?php

namespace Nomala\StatamicGooglePlaces\Tags;

use Nomala\StatamicGooglePlaces\GooglePlaces;
use Statamic\Tags\Tags;

class Place extends Tags
{
    /**
     * {{ place }} ... {{ /place }}
     */
    public function index()
    {
        if (!env('GOOGLE_MAPS_API_KEY')) {
            return 'Please add a GOOGLE_MAPS_API_KEY to the .env file';
        }

        return [];
    }

    /**
     * {{ place:nearby lat="value" lng="value" radius="value" }} ... {{ /place }}
     */
    public function nearby()
    {
        $photos = [];

        $lat = $this->params->get('lat');
        $lng = $this->params->get('lng');
        $radius = $this->params->get('radius');

        if (!$lat || !$lng) {
            return 'Please set both latitude and longitude';
        }

        $location = $lat . ',' .$lng;

        $googlePlaces = new GooglePlaces();
        $photos = $googlePlaces->nearbySearch($location, $radius);

        return $photos;
    }

    /**
     * {{ place:photos input="value" }} ... {{ /place }}
     */
    public function photos()
    {
        $photos = [];

        if (!$input = $this->params->get('input')) {
            return 'The text input specifying which place to search for is missing.';
        }

        $googlePlaces = new GooglePlaces();
        $photos = $googlePlaces->getPhotos($input);

        return $photos;
    }
}