<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Resources\API\BikeResource;
use App\Http\Resources\API\PaginatedCollection;
use App\Models\Bike;
use Illuminate\Database\Eloquent\Builder;
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
        $orderBy = $request->get('order', 'desc');
        $perPage = $request->get('per_page', config('constants.pagination.per_page'));
        $currentPage = $request->get('page', 1);

        $data = $this->bikeModel
            ->when(request('shop_id'), function (Builder $q) {
                $q->where('shop_id', request('shop_id'));
            })->when(request('category_id'), function (Builder $q) {
                $q->where('bike_category_id', request('category_id'));
            })->orderBy($sortColumn, $orderBy)
            ->paginate($perPage, $columns, 'page', $currentPage);
        $collection = new PaginatedCollection($data, BikeResource::class);
        $response = $collection->toArray($request);
        return $this->successResponse($response);
    }

    public function show($id, Request $request)
    {
        $data = $this->bikeModel->find($id);

        if ($data == null)
            return $this->successResponse(null);

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
            ->when(request('shop_id'), function (Builder $q) {
                $q->where('shop_id', request('shop_id'));
            })
            ->orderBy($sortColumn, $orderBy)
            ->select($columns)
            ->get();
        $collection = BikeResource::collection($data);
        $response = $collection->toArray($request);
        return $this->successResponse($response);
    }
}
