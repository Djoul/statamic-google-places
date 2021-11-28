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

### Find place

This tag takes a text input and return a place. See [Google's Official documentation](https://developers.google.com/maps/documentation/places/web-service/search-find-place) for more information. 

NB: The input type 'textquery' is used by default and can't be modified.

```
{{ place:find input="The text input specifying which place to search for" }} ... {{ /place:find }}
```

#### Parameter(s)

* `input` — The text input specifying which place to search for (name or address).

##### Example

```php
{{ place:find input="paris" }}
    {{ place_id }}
{{ /place:find }}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
