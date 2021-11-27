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
     * @return \Illuminate\Support\Collection
     */
    public function getPlaceIds($place)
    {
        $places = $this->placeApi->findPlace($place, 'textquery');

        if (!$places) {
            return;
        }

        return $places->get('candidates')->all();
    }

    /**
     * Get photos for a place.
     *
     * @param $place
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPhotos($place)
    {
        $photos = [];

        $placeIds = $this->getPlaceIds($place);

        foreach ($placeIds as $placeId) {

            $placeDetails = $this->placeApi->placeDetails($placeId['place_id']);
            $placePhotos = $placeDetails->all()['result']['photos'];

            foreach ($placePhotos as $placePhoto) {
                $photos[] = [
                    'photo' => $placePhoto['photo_reference'],
                    'photoUrl' => 'https://maps.googleapis.com/maps/api/place/photo?photoreference=' . $placePhoto['photo_reference'] . '&key=' . env('GOOGLE_MAPS_API_KEY', 'your-key') . '&maxheight=1000&maxwidth=600'
                ];
            }

        }

        return $photos;        
    }
}
