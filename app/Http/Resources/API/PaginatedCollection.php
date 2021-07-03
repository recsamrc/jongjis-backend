<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedCollection extends ResourceCollection
{
    public $pagination;
    
    private $resourceClass;
    public $resource;
    private $keyData;

    public function __construct($resource, $resourceClass, $keyData = 'data')
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
        $this->resourceClass = $resourceClass;
        $this->keyData = $keyData;
    }

    public function toArray($request)
    {
        return [
            $this->keyData => $this->resourceClass::collection($this->collection),
            'pagination' => [
                'current_page' => $this->resource->currentPage(),
                'last_page' => $this->resource->lastPage(),
                'per_page' => $this->resource->perPage(),
                'from' => $this->resource->firstItem(),
                'to' => $this->resource->lastItem(),
                'count' => $this->resource->count(),
                'total' => $this->resource->total()
            ]
        ];
    }
}
