<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
{
    public $withDetails;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->withDetails = false;
    }

    public function toArray($request)
    {
        $bikes = $this->bikes;
        if ($this->withDetails) {
            return [
                'id' => (string) $this->id,
                'shop_name' => (string) $this->shop_name,
                'address' => (string) $this->address,
                'cover_image' => (string) $this->cover,
                'opening_hours' => (string) $this->getOpeningHours(),
                'bikes_count' => (int) $bikes->count(),
                'bikes_booked_count' => (int) 0,
                'bikes_available_count' => (int)  $bikes->where('avaliablity', 1)->count(),
                'bikes_unavailable_count' => (int)  $bikes->where('avaliablity', 0)->count(),
                'bikes' => BikeResource::collection($bikes),
            ];
        } else {
            return  [
                'id' => (string) $this->id,
                'shop_name' => (string) $this->shop_name,
                'opening_hours' => (string) $this->getOpeningHours(),
                'tel' => (string) $this->contact_no,
                'cover_image' => (string) $this->cover,
            ];
        }
    }

    protected function getOpeningHours() {
        return '[{"open_time":"5:00","close_time":"20:00","day":"mon"}, {"open_time":"5:00","close_time":"20:00","day":"tue"}, {"open_time":"5:00","close_time":"20:00","day":"wed"}, {"open_time":"5:00","close_time":"20:00","day":"thu"}, {"open_time":"5:00","close_time":"20:00","day":"fri"}k{"open_time":"5:00","close_time":"20:00","day":"sat"}, {"open_time":"5:00","close_time":"20:00","day":"sun"}]';
    }
}
