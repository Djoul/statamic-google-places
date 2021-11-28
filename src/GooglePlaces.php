<?php

namespace Nomala\StatamicGooglePlaces;

use SKAgarwal\GoogleApi\PlacesApi;

class GooglePlaces
{
    /**
     * The PlacesApi object
     * @var SKAgarwal\GoogleApi\PlacesApi
     */
    protected $placeApi;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        if (!config('statamic.places.gmap_api_key')) {
            return 'Please add a GOOGLE_MAPS_API_KEY to the .env file';
        }

        $this->placeApi = new PlacesApi(config('statamic.places.gmap_api_key'));
    }

    /**
     * Get photos for a place.
     *
     * @param $place
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getPhotos($place)
    {
        $photos = [];

        $placeIds = $this->findPlace($place, 'textquery');

        if (!$placeIds) {
            return null;
        }

        foreach ($placeIds as $placeId) {
            $placeDetails = $this->placeApi->placeDetails($placeId['place_id']);

            if (!$placeDetails) {
                continue;
            }

            $placePhotos = isset($placeDetails->all()['result']['photos']) ? $placeDetails->all()['result']['photos'] : [];

            foreach ($placePhotos as $placePhoto) {
                $photos[] = [
                    'photo' => $placePhoto['photo_reference'],
                    'photoUrl' => 'https://maps.googleapis.com/maps/api/place/photo?photoreference=' . $placePhoto['photo_reference'] . '&key=' . config('statamic.places.gmap_api_key') . '&maxheight=1000&maxwidth=600'
                ];
            }
        }

        return collect($photos);
    }

    /**
     * Search for places within a specified area.
     *
     * @param string $location
     * @param int $radius
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function nearbySearch($location, $radius = 500)
    {
        $places = $this->placeApi->nearbySearch($location, $radius);

        if (!isset($places->all()['results']) || !$places->all()['results']->count()) {
            return null;
        }

        return collect($places->all()['results']->all());
    }

    /**
     * Find a place from search string.
     *
     * @param string $input
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function findPlace($input)
    {
        $places = $this->placeApi->findPlace($input, 'textquery');

        if (!$places->get('candidates')->count()) {
            return null;
        }

        return collect(array_values($places->get('candidates')->all()));
    }

    /**
     * Return a place details.
     *
     * @param string $placeId
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function placeDetails($placeId)
    {
        $places = $this->placeApi->placeDetails($placeId);
       

        if (!count($places->get('result'))) {
            return null;
        }

        return collect($places->get('result'));
    }
}
