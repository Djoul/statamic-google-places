<?php

namespace Nomala\StatamicGooglePlaces\Helpers;

use Illuminate\Support\Str;
use Statamic\Facades\Addon;

class PlaceHelper
{
    public static function googleMapsUrl()
    {
        return 'https://maps.googleapis.com/maps/api/js?libraries=places&key=' . env('GOOGLE_MAPS_API_KEY', 'your-key');
    }
}
