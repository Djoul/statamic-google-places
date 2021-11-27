<?php

namespace Nomala\StatamicGooglePlaces;

use SKAgarwal\GoogleApi\PlacesApi;

class GooglePlaces {

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
        if (!env('GOOGLE_MAPS_API_KEY')) {
            return 'Please add a GOOGLE_MAPS_API_KEY to the .env file';
        }

        $this->placeApi = new PlacesApi(env('GOOGLE_MAPS_API_KEY', 'your-key'));
    }

    /**
     * Get all places id from the provided place string.
     *
     * @param $place
     *
     * @return array
     */
    public function getPlaceIds($place)
    {
        $places = $this->placeApi->findPlace($place, 'textquery');

        if (!$places->get('candidates')->count()) {
            return null;
        }

        return array_values($places->get('candidates')->collapse()->all());
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

        $placeIds = $this->getPlaceIds($place);

        if(!$placeIds) {
            return null;
        }

        foreach ($placeIds as $placeId) {

            $placeDetails = $this->placeApi->placeDetails($placeId);

            if (!$placeDetails) {
                continue;
            }

            $placePhotos = isset($placeDetails->all()['result']['photos']) ? $placeDetails->all()['result']['photos'] : [];

            foreach ($placePhotos as $placePhoto) {
                $photos[] = [
                    'photo' => $placePhoto['photo_reference'],
                    'photoUrl' => 'https://maps.googleapis.com/maps/api/place/photo?photoreference=' . $placePhoto['photo_reference'] . '&key=' . env('GOOGLE_MAPS_API_KEY', 'your-key') . '&maxheight=1000&maxwidth=600'
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

        if(!isset($places->all()['results']) || !$places->all()['results']->count()) {
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
