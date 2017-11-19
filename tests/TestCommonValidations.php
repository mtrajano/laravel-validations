<?php

namespace Mtrajano\LaravelValidations\Tests;

use Orchestra\Testbench\TestCase;
use Mtrajano\LaravelValidations\LaravelValidationsServiceProvider;

class TestCommonValidations extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [LaravelValidationsServiceProvider::class];
    }

    /**
     * @test
     */
    public function testZip()
    {
        $this->assertFalse(\Validator::make(['value' => '1234'], ['value' => 'zipcode'])->passes());
        $this->assertTrue(\Validator::make(['value' => '12345'], ['value' => 'zipcode'])->passes());
        $this->assertFalse(\Validator::make(['value' => '12345-'], ['value' => 'zipcode'])->passes());
        $this->assertFalse(\Validator::make(['value' => '123121234'], ['value' => 'zipcode'])->passes());
        $this->assertTrue(\Validator::make(['value' => '12312-1234'], ['value' => 'zipcode'])->passes());
    }

    /**
     * @test
     */
    public function testLatitude()
    {
        $this->assertTrue(\Validator::make(['value' => '87.112301031'], ['value' => 'latitude'])->passes());
        $this->assertTrue(\Validator::make(['value' => '-7'], ['value' => 'latitude'])->passes());
        $this->assertTrue(\Validator::make(['value' => '0'], ['value' => 'latitude'])->passes());
        $this->assertFalse(\Validator::make(['value' => '-157.123523'], ['value' => 'latitude'])->passes());
        $this->assertFalse(\Validator::make(['value' => null], ['value' => 'latitude'])->passes());
    }

    /**
     * @test
     */
    public function testLongitude()
    {
        $this->assertTrue(\Validator::make(['value' => '-157.123523'], ['value' => 'longitude'])->passes());
        $this->assertFalse(\Validator::make(['value' => '-200'], ['value' => 'longitude'])->passes());
        $this->assertFalse(\Validator::make(['value' => '0asdfaf'], ['value' => 'longitude'])->passes());
    }

    /**
     * @test
     */
    public function testRoutingNumber()
    {
        $this->assertTrue(\Validator::make(['value' => '122100024'], ['value' => 'routing'])->passes());
        $this->assertFalse(\Validator::make(['value' => '123123124'], ['value' => 'routing'])->passes());
    }

    /**
     * @test
     */
    public function testCountryCode()
    {
        $this->assertTrue(\Validator::make(['value' => 'us'], ['value' => 'countrycode'])->passes());
        $this->assertFalse(\Validator::make(['value' => 'USA'], ['value' => 'countrycode:iso2'])->passes());
        $this->assertTrue(\Validator::make(['value' => 'USA'], ['value' => 'countrycode:iso3'])->passes());
        $this->assertFalse(\Validator::make(['value' => 'XYZ'], ['value' => 'countrycode:iso3'])->passes());
    }

    /**
     * @test
     */
    public function testUUID()
    {
        $this->assertTrue(\Validator::make(['value' => 'ec85e9ec-cc86-11e7-bd2f-080027a8df8b'], ['value' => 'uuid'])->passes());
        $this->assertTrue(\Validator::make(['value' => 'F4E24A3B-CC86-11E7-BD2F-080027A8DF8B'], ['value' => 'uuid'])->passes());
        $this->assertFalse(\Validator::make(['value' => 'F4E24A3B-CC86-11E7-BD2F-08ZXG7A8DF8B'], ['value' => 'uuid'])->passes());
    }
}