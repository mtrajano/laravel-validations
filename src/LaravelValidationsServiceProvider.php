<?php

namespace Mtrajano\LaravelValidations;

use Illuminate\Support\ServiceProvider;

class LaravelValidationsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        foreach ([
            'uuid' => 'UUID',
            'phone' => 'Phone',
            'zipcode' => 'ZipCode',
            'routing' => 'RoutingNumber',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'countrycode' => 'CountryCode',
        ] as $name => $func) {
            $this->app['validator']->extend($name, "Mtrajano\LaravelValidations\CommonValidations@validate$func");
        }
    }

    /**
     * @return void
     */
    public function register()
    {
    }
}