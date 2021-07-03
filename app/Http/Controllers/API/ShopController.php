<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Http\Resources\API\PaginatedCollection;
use App\Http\Resources\API\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends APIController
{
    protected $shopModel;

    public function __construct(Shop $shopModel)
    {
        $this->shopModel = $shopModel;
    }

    public function index(Request $request)
    {
        $columns = ['*'];
        $sortColumn = $request->get('sort', 'updated_at');
        $orderBy = $request->get('order', 'desc');
        $perPage = $request->get('per_page', config('constants.pagination.per_page'));
        $currentPage = $request->get('page', 1);

        $data = $this->shopModel
            ->orderBy($sortColumn, $orderBy)
            ->paginate($perPage, $columns, 'page', $currentPage);
        $collection = new PaginatedCollection($data, ShopResource::class);
        $response = $collection->toArray($request);
        return $this->successResponse($response);
    }

    public function all(Request $request)
    {
        $columns = ['*'];
        $sortColumn = $request->get('sort', 'updated_at');
        $orderBy = $request->get('order', 'asc');

        $data = $this->shopModel
            ->orderBy($sortColumn, $orderBy)
            ->select($columns)
            ->get();
        $collection = ShopResource::collection($data);
        $response = $collection->toArray($request);
        return $this->successResponse($response);
    }

    public function show($id, Request $request)
    {
        $data = $this->shopModel->find($id);

        if ($data == null)
            return $this->successResponse(null);

        $resource = new ShopResource($data);
        $resource->withDetails = true;
        $response = $resource->toArray($request);
        return $this->successResponse($response);
    }
}
