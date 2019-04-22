<?php

namespace App\Logic;
use App\Country;
use App\Forecast;
use App\Location;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Created by PhpStorm.
 * User: elena
 * Date: 22/04/2019
 * Time: 01:38
 */
class LocationForecastBuilder
{
    private static $instance;
    private $countries;

    /**
     * LocationForecastBuilder constructor.
     */
    private function __construct()
    {
        $this->countries = Country::pluck('name', 'alpha2code');
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getLocationForecast(Location $location) : LocationForecast {
        $locationForecast = new LocationForecast();

        $locationForecast->setLocationId($location->id);
        $locationForecast->setCity($location->city);
        $locationForecast->setCountry($this->countries[$location->country_alpha2code]);

        $forecasts = Forecast::where('location_id', '=', $location->id)
            ->where('date', '>', Carbon::now())
            ->orderBy('date')
            ->get()->toArray();

        $locationForecast->setForecast(
            new Collection($forecasts)
        );
        return $locationForecast;
    }
}