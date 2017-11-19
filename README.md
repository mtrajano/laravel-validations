# Common Laravel Validation Rules

A set of common validation rules that I found myself using throughout a lot of my applications. Laravel's Validator will be extended with the set of rules so no configuration is required. 

## Installation
Simply install via composer:
```bash
composer require mtrajano/laravel-validations
```
For Laravel <=5.4, make sure to also add the service provider to your `config/app.php` class:
```
Mtrajano\LaravelValidations\LaravelValidationsServiceProvider::class
```

## Validation Rules
- **zipcode**: US ZIP and ZIP+4 formats
- **latitude**: Any float value between -90 and 90, inclusive
- **longitude**: Any float between between -180 and 180, inclusive
- **routing**: Must be a valid routing number passing the ABA checksum
- **countrycode**: Valid country code (either ISO2 or ISO3 formats)
- **phone**: Valid US phone number
- **uuid**: A valid Universally Unique ID according to RFC 4122

## Contributing
Pull requests and issues are welcome!


