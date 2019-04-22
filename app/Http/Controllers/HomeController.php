<?php
/**
 * Created by PhpStorm.
 * User: elena
 * Date: 18/04/2019
 * Time: 20:16
 */

namespace App\Http\Controllers;


use App\Country;
use App\Forecast;
use App\Location;
use App\Logic\LocationForecastBuilder;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $forecasts = [];
        Location::all()->each(function ($location) use (&$forecasts){
            $forecasts[] = LocationForecastBuilder::getInstance()->getLocationForecast($location);
        });

        $data['forecasts'] = $forecasts;
        $content = View::make(
            'index',
            $data
        );

        return View::make($this->layout, ['content' => $content]);
    }
}