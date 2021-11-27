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
     * {{ place:find input="The text input specifying which place to search for" }} ... {{ /place:find }}
     */
    public function find()
    {
        if (!$input = $this->params->get('input')) {
            return 'The text input specifying which place to search for is missing.';
        }

        return (new GooglePlaces())->findPlace($input);
    }

    /**
     * {{ place:nearby lat="value" lng="value" radius="value" }} ... {{ /place:nearby }}
     */
    public function nearby()
    {
        $lat = $this->params->get('lat');
        $lng = $this->params->get('lng');
        $radius = $this->params->get('radius');

        if (!$lat || !$lng) {
            return 'Please set both latitude and longitude';
        }

        $location = $lat . ',' .$lng;

        return (new GooglePlaces())->nearbySearch($location, $radius);
    }

    /**
     * {{ place:details place_id="Unique place identifier" }} ... {{ /place:details }}
     */
    public function details()
    {
        if (!$placeId = $this->params->get('place_id')) {
            return 'The place identifier is missing.';
        }

        return (new GooglePlaces())->placeDetails($placeId);
    }

    /**
     * {{ place:photos input="value" }} ... {{ /place:photos }}
     */
    public function photos()
    {
        if (!$input = $this->params->get('input')) {
            return 'The text input specifying which place to search for is missing.';
        }

        return (new GooglePlaces())->getPhotos($input);
    }
}