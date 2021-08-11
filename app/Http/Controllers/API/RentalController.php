<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Models\Bike;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends APIController
{
    protected $rentalModel;
    protected $bikeModel;

    public function __construct(Rental $rentalModel, Bike $bikeModel)
    {
        $this->middleware('auth:api');
        
        $this->rentalModel = $rentalModel;
        $this->bikeModel = $bikeModel;
    }
    
    public function book(Request $request)
    {
        $attributes = $request->all();

        try {
            $bike = $this->bikeModel->find($attributes['bike_id']);
            $attributes['client_id'] = auth()->id();
            $attributes['total_amount'] = $bike->rent_price;
            $rental = Rental::create($attributes);

            return $rental;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }

}
