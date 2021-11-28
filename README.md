# Statamic Google Places
A Google Places addon for Statamic V3 for displaying Google Places on your website.

## Installation

You can install the package via composer:

```bash
composer require nomala/statamic-google-places
```

Optionally publish the config file of this package:

```bash
php artisan vendor:publish --provider="Nomala\StatamicGooglePlaces\StatamicGooglePlacesServiceProvider"
```

Add an environment variable. Provide the Google API key that you want to use for this project.

```
GOOGLE_MAPS_API_KEY=""
```

## Places Tags

Insert one of the tags below into your antlers template.

### place:find

This tag takes a text input and return a place. See [Google's Official documentation](https://developers.google.com/maps/documentation/places/web-service/search-find-place) for more information. 

NB: The input type 'textquery' is used by default and can't be modified.

```
{{ place:find input="The text input specifying which place to search for" }} ... {{ /place:find }}
```

#### Parameter(s)

* `input` — The text input specifying which place to search for (name or address).

#### Example

```php
{{ place:find input="paris" }}
    {{ place_id }}
{{ /place:find }}
```

### place:nearby

Search for places within a specified area. See [Google's Official documentation](https://developers.google.com/maps/documentation/places/web-service/search-nearby) for more information. 

```
{{ place:nearby lat="50.8549541" lng="4.3053504" radius="1000" }} ... {{ /place:nearby }}
```

#### Parameter(s)

* `lat` — The latitude of the place.
* `longitude` — The longitude of the place.
* `radius` — Defines the distance (in meters) within which to return place results.

#### Example

```php
{{ place:nearby lat="50.1488041" lng="5.6335469" radius="100" }}
    {{ name }}, {{ place_id }} <br>
{{ /place:nearby }}
```

### place:details

Request for details about a place. See [Google's Official documentation](https://developers.google.com/maps/documentation/places/web-service/details) for more information. 

```
{{ place:details place_id="ChIJny45LXAmwkcR2dHbpmB1TFw" }} ... {{ /place:details }}
```

#### Parameter(s)

* `place_id` — A textual identifier that uniquely identifies a place.

#### Example

```php
{{ place:details place_id="ChIJQ_kGl9o4wEcRWTAF0xd-gNs" }}
    {{ name }} <br>
    {{ geometry.location.lat }} <br>
    {{ geometry.location.lng }} <br>
    {{ formatted_address }}
{{ /place:details }}
```

### place:photos

Request that return all the photos from a find search.

```
{{ place:photos input="brussels" }} ... {{ /place:photos }}
```

#### Parameter(s)

* `input` — The text input specifying which place to search for (name or address).

#### Example

```php
{{ place:photos input="brussels" }}
    {{ photo }} <br>,
    <img src="{{ photoUrl }}" /> <br>
{{ /place:photos }}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
