<?php

namespace App\Actions;

use App\Models\Vehicle;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetVehicleLocationAction
{
    /**
     * @throws ConnectionException
     * @throws \Exception
     */
    public function execute()
    {
        // make http request to get vehicle location
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

        return $response->json()[0]['vehicleLocations'];
    }

}