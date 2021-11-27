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
}
