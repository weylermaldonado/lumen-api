<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'products',
                'id' => $this->id,
                'attributes' => [
                    'name' => $this->name,
                    'price' => $this->price
                ],
                'links' => [
                    'self' => 'http://localhost/api/products/'.$this->id
                ]
            ],
        ];
    }
}