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
                'id' => (string) $this->id,
                'bike_name' => (string) $this->bike_name,
                'feature_image' => (string) $this->feature_image_url,
                'description' => (string) $this->description,
                'images' => ImageResource::collection($this->images),
            ] : [
                'id' => (string) $this->id,
                'bike_name' => (string) $this->bike_name,
                'rent_price' => (string) $this->rent_price,
                'feature_image' => (string) $this->feature_image_url,
            ];
    }
}
