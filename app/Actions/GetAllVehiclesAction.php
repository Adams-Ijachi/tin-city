<?php

namespace App\Actions;

use App\Models\Vehicle;

class GetAllVehiclesAction
{

    public function execute()
    {
        return Vehicle::all();
    }
}