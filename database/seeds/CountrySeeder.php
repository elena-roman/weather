<?php

use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client   = new GuzzleHttp\Client(['base_uri' => 'http://restcountries.eu']);
        $response = $client->get('/rest/v2/all');

        if ($response->getStatusCode() != \Illuminate\Http\Response::HTTP_OK) {
            return;
        }

        \App\Country::query()->truncate();

        $countries = json_decode($response->getBody()->getContents());
        $batch     = [];
        foreach ($countries as $country) {

            if (count($batch) > 500) {
                \App\Country::insert($batch);
                $batch = [];
            }

            $batch[] = [
                'alpha2code' => $country->alpha2Code,
                'name'       => $country->name,
            ];
        }

        \App\Country::insert($batch);
    }
}
