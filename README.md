# Statamic Google Places
A Google Places addon for Statamic V3 for displaying Google Places on your website.

# Installation

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

# Places Tags

Insert one of the tags below into your antlers template.

## Find place

This tag takes a text input and return a place. See [Google's Official documentation](https://developers.google.com/maps/documentation/places/web-service/search-find-place) for more information. 

NB: The input type 'textquery' is used by default and can't be modified.

```
{{ place:find }} ... {{ /place:find }}
```

### Parameter(s)

* `input` — The text input specifying which place to search for (name or address).
* `input_type` — The type of input - `textquery` or `phonenumber` (`textquery` is set as default).
* `parameters` — Optional parameters - please see Google's Official documentation for more information on all the available parameters. All parameters are separated using the ampersand `&` character. 

### Example

```php
{{ place:find input="paris" input_type="textquery" parameters="language=fr" }}
    {{ place_id }}
{{ /place:find }}
```

## Nearby Search

Search for places within a specified area. See [Google's Official documentation](https://developers.google.com/maps/documentation/places/web-service/search-nearby) for more information. 

```
{{ place:nearby }} ... {{ /place:nearby }}
```

### Parameter(s)

* `lat` — The latitude of the place.
* `longitude` — The longitude of the place.
* `radius` — Defines the distance (in meters) within which to return place results.
* `parameters` — Optional parameters - please see Google's Official documentation for more information on all the available parameters. All parameters are separated using the ampersand `&` character. 

### Example

```php
{{ place:nearby lat="40.6971494" lng="-74.2598655" radius="10000" parameters="type=doctor&rankby=distance" }}
    {{ name }}, {{ place_id }} <br>
{{ /place:nearby }}
```

## Place Details

Request for details about a place. See [Google's Official documentation](https://developers.google.com/maps/documentation/places/web-service/details) for more information. 

```
{{ place:details }} ... {{ /place:details }}
```

### Parameter(s)

* `place_id` — A textual identifier that uniquely identifies a place.
* `parameters` — Optional parameters - please see Google's Official documentation for more information on all the available parameters. All parameters are separated using the ampersand `&` character.

### Examples

```php
{{ place:details place_id="ChIJYeZuBI9YwokRjMDs_IEyCwo" parameters="fields=formatted_address,name,geometry&language=fr" }}
    {{ name }} <br>
    {{ geometry.location.lat }} <br>
    {{ geometry.location.lng }} <br>
    {{ formatted_address }}
{{ /place:details }}
```

To get the place ID and details:

```php
{{ place:find input="paris" }}
    {{ place:details place_id="{ place_id }" }}
        {{ name }} <br>
        {{ formatted_address }}
    {{ /place:details }}
{{ /place:find }}
```

## Photos from search

Request that return all the photos from a find search.

```
{{ place:photos }} ... {{ /place:photos }}
```

### Parameter(s)

* `input` — The text input specifying which place to search for (name or address).

### Example

```php
{{ place:photos input="Manhattan" }}
    {{ photo }} <br>,
    <img src="{{ photoUrl }}" /> <br>
{{ /place:photos }}
```

## Tips

If you want to see all the available data inside a loop, use the `dump`tag.

```php
{{ place:photos input="Manhattan" }}
    {{ dump }}
{{ /place:photos }}
```

# License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
