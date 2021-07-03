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
        return
            $this->withDetails ? [] : [
                'id' => (string) $this->id,
                'shop_name' => (string) $this->shop_name,
                'tel' => (string) $this->contact, 
            ];
    }
}
