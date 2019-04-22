<?php

namespace App\Http\Controllers\Dashboard;

use App\Country;
use App\Forecast;
use App\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;

class LocationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $data['countries'] = Country::pluck('name', 'alpha2code');

        $content = View::make(
            'pages.location.location-form',
            $data
        );

        return View::make($this->layout, ['content' => $content]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = new Location();
        $location->fill($request->all(['country_alpha2code', 'city']));
        $location->save();

        Artisan::call('import:forecast');

        return redirect()->action('HomeController@index');
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function destroy($id, Request $request)
    {
        Location::find($id)->delete();
        Forecast::where('location_id', '=', $id)->delete();

        return redirect()->action('HomeController@index');
    }
}
