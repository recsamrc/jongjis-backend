<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Requests\API\BikeRequest;
use App\Http\Resources\API\BikeResource;
use App\Http\Resources\API\PaginatedCollection;
use App\Models\Bike;
use Illuminate\Http\Request;

class BikeController extends APIController
{
    protected $bikeModel;

    public function __construct(Bike $bikeModel)
    {
        $this->bikeModel = $bikeModel;
    }


    public function index(Request $request)
    {
        $columns = ['*'];
        $sortColumn = $request->get('sort', 'updated_at');
        $orderBy = $request->get('order', 'asc');
        $perPage = $request->get('per_page', config('constants.pagination.per_page'));
        $currentPage = $request->get('page', 1);

        $data = $this->bikeModel
            // ->orderBy($sortColumn, $orderBy)
            ->paginate($perPage, $columns, 'page', $currentPage);
        $collection = new PaginatedCollection($data, BikeResource::class);
        $response = $collection->toArray($request);
        return $this->successResponse($response);
    }

    public function show($id, Request $request)
    {
        $data = $this->bikeModel->find($id);
        $resource = new BikeResource($data);
        $resource->withDetails = true;
        $response = $resource->toArray($request);
        return $this->successResponse($response);
    }

    public function all(Request $request)
    {
        $columns = ['*'];
        $sortColumn = $request->get('sort', 'updated_at');
        $orderBy = $request->get('order', 'asc');

        $data = $this->bikeModel
            // ->orderBy($sortColumn, $orderBy)
            ->get();
        $collection = BikeResource::collection($data);
        $response = $collection->toArray($request);
        return $this->successResponse($response);
    }

    public function store(BikeRequest $request)
    {
        $attribute = $request->validated();
        $bike = Bike::create($attribute);
        if ($bike == null) {
            return $this->successResponse('Failed to create bike!');
        }
        return $this->successResponse('Bike created successfully!');
    }

    public function update(Request $request, $id)
    {
        try {
            $bike = Bike::findOrFail($id);
            return $bike;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            return Bike::findOrFail($id)->delete();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
