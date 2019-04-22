<?php

namespace App\Logic;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Created by PhpStorm.
 * User: elena
 * Date: 22/04/2019
 * Time: 01:38
 */
class LocationForecast
{
    private $locationId;
    private $city;
    private $country;
    private $forecast;

    /**
     * @return mixed
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @param mixed $locationId
     */
    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return Collection
     */
    public function getForecast() : Collection
    {
        return $this->forecast;
    }

    /**
     * @param Collection $forecast
     */
    public function setForecast($forecast)
    {
        $this->forecast = $forecast;
    }

    public function getDegrees() {
        return $this->getForecast()->first()['temp'];
    }

    public function getDescription() {
        return $this->getForecast()->first()['description'];
    }

    public function getNextDaysForecast() {
        $forecast = $this->getForecast()->reject(function ($value, $key) {
            return Carbon::now('UTC')->format('d') >= Carbon::parse($value['date'],'UTC')->format('d');
        });

        $forecast = $forecast->groupBy(function ($value, $key) {
            return Carbon::parse($value['date'], 'UTC')->dayName;
        });


        return $forecast;
    }
}