<?php

namespace App\Http\Controllers;

use App\Actions\GetAllVehiclesAction;

class AdminDashboardController extends Controller
{
    public function __invoke(GetAllVehiclesAction $getAllVehiclesAction)
    {
        // get all vehicles
        $vehicles = $getAllVehiclesAction->execute();

        return view('welcome', compact('vehicles'));
    }
}
