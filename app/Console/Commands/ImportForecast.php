<?php

namespace App\Console\Commands;

use App\Forecast;
use App\Location;
use Illuminate\Console\Command;
use Illuminate\Http\Response;

class ImportForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'http://api.openweathermap.org',
            'verify'   => false
        ]);

        Location::all()->each(function ($location) use ($client) {
            $city    = $location->city;
            $country = $location->country_alpha2code;

            $response = $client->get("data/2.5/forecast?appid=de86c9bbf007099e028d9990eee4145b&units=metric&q=$city,$country");

            if ($response->getStatusCode() != Response::HTTP_OK) {
                return;
            }

            $results = json_decode($response->getBody()->getContents());
            $this->batchInsert($results->list, $location->id);
        });
    }


    private function batchInsert($forecast, $locationId)
    {
        Forecast::where('location_id', '=', $locationId)->delete();

        $batch = [];

        foreach ($forecast as $result) {
            if (count($batch) > 500) {
                Forecast::insert($batch);
                $batch = [];
            }

            $batch[] = [
                'location_id' => $locationId,
                'date'        => $result->dt_txt,
                'temp'        => $result->main->temp,
                'description' => $result->weather[0]->description,
            ];
        }

        Forecast::insert($batch);
    }
}
