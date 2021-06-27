<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\BikeRequest;
use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bikes = Bike::latest();
        return $this->successResponse('Bikes retreived successfully!', $bikes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BikeRequest $request)
    {
        $attribute = $request->validated();
        $bike = Bike::create($attribute);
        if ($bike == null) {
            return $this->successResponse('Failed to create bike!');
        }
        return $this->successResponse('Bike created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bike = Bike::find($id);
        return $bike;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $bike = Bike::findOrFail($id);
            return $bike;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return Bike::findOrFail($id)->delete();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
