<?php

namespace App\View\Components;

use App\Actions\GetAllVehiclesAction;
use Illuminate\View\Component;

class VechicleListSidebar extends Component
{

    public  $vehicles;
    public function __construct(GetAllVehiclesAction $getAllVehiclesAction)
    {

    }

    public function render()
    {
        $this->vehicles = app(GetAllVehiclesAction::class)->execute();
        return view('components.vechicle-list-sidebar');
    }
}
