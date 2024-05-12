<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SeedVechicleSeeder extends Seeder
{
    public function run()
    {
        $url = config('tincity.gps_domain_name') . "/apiMobile/getVehicleLocations";

        $response = Http::withQueryParameters([
            'userId' => config('tincity.user_id'),
            'apiKey' => config('tincity.api_key'),
            'groupId' => config('tincity.group_id')
        ])->get($url);

        if ($response->failed()){
            Log::error('Error Seeding Vehicles', [
                'error' => $response
            ]);
        }
//        $json  = file_get_contents(base_path('database/seeders/test.json'));
//        $json = json_decode($json, true);
        collect($response->json())->map(function ($group){

                collect($group['vehicleLocations'])->map(function ($vehicle){

                    Vehicle::updateOrCreate([
                        'group_name' => $vehicle['groupName'],
                        'vehicle_Id' => $vehicle['vehicleId']
                    ],[
                        'name' => $vehicle['shortName'],
                        'device_Id' => $vehicle['deviceId'],
                        'vehicle_type' => $vehicle['vehicleType']
                    ]);

                });
       });





    }
}
