<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class BikeResource extends JsonResource
{
    public $withDetails;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->withDetails = false;
    }

    public function toArray($request)
    {
        return
            $this->withDetails ? [
                'id' => $this->id,
                'bike_name' => $this->bike_name,
                'feature_image' => $this->feature_image_url,
                'description' => $this->description,
                'images' => ImageResource::collection($this->images),
            ] : [
                'id' => $this->id,
                'bike_name' => $this->bike_name,
                'feature_image' => $this->feature_image_url,
            ];
    }
}
