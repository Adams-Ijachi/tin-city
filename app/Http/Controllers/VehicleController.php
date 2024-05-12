<?php

namespace App\Http\Controllers;

use App\Actions\GetAllVehiclesAction;
use App\Actions\GetVehicleLocationAction;
use App\Models\Vehicle;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VehicleController extends Controller
{
    public function index(Vehicle $vehicle ,GetAllVehiclesAction $getAllVehiclesAction)
    {
        $vehicles = $getAllVehiclesAction->execute();

        return view('vehicle-location',compact('vehicles'));
    }

    public function getLocation(){

        $response = new StreamedResponse(function () use () {
            while (true) {
                try {
                    $location = (new GetVehicleLocationAction())->execute();
                    echo "data: " . json_encode(['vehicle_locations' => $location, 'status' => 'success']) . "\n\n";
                    ob_flush();
                    flush();
                    // 5 seconds
                    usleep(5000000);
                } catch (\Exception $e) {
                    echo "data: " . json_encode(['error' => $e->getMessage(), 'status' => 'failure']) . "\n\n";
                    ob_flush();
                    flush();
//                    sleep(10);
                    usleep(5000000);
                }
            }
        });
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cache-Control', 'no-cache');
        return $response;


    }
}
